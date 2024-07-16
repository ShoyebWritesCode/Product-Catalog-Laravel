<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Admin;
use App\Models\OrderItems;
use App\Models\Order;
use App\Models\Color;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\MyEmail;
use App\Models\EmailTemplate;
use App\Helpers\MailHelper;
use App\Notifications\OrderPlaced;
use Illuminate\Support\Facades\Notification;
use App\Http\Controllers\AddressController;
use App\Models\Inventory;
use Stripe;
use App\Models\PaymentHistory;

class OrderController extends Controller
{
    protected $addressController;
    public function __construct(AddressController $addressController)
    {
        $this->addressController = $addressController;
    }


    protected function getOrderData()
    {
        $user = auth()->user();
        $order = Order::where('user_id', $user->id)->where('status', 0)->first();
        $orderItems = collect();
        $addressData = $this->addressController->index();

        if ($order) {
            $orderItems = OrderItems::where('order_id', $order->id)->get();
        }

        return [
            'order' => $order,
            'orderItems' => $orderItems,
            'address' => $addressData['address'],
            'billingaddress' => $addressData['billingAddress']
        ];
    }


    public function index()
    {
        $data = $this->getOrderData();
        $data['order']->total = 0;
        $data['order']->save();


        return view('customer.order.home', $data);
    }

    public function popup()
    {
        $data = $this->getOrderData();

        return view('customer.order.popup', $data);
    }

    public function shipping()
    {
        $data = $this->getOrderData();
        return view('customer.order.shipping', $data);
    }
    public function billing()
    {
        $data = $this->getOrderData();
        return view('customer.order.billing', $data);
    }
    public function getShippingAddress($id)
    {
        $order = Order::find($id);

        if ($order) {
            return response()->json([
                'city' => $order->city,
                'address' => $order->address,
                'phone' => $order->phone,
            ]);
        } else {
            return response()->json(['error' => 'Order not found'], 404);
        }
    }

    public function checkoutpage()
    {

        $data = $this->getOrderData();
        return view('customer.order.checkout', $data);
    }



    public function add(Request $request, Product $product)
    {
        // $num = 0;
        $user = auth()->user();
        $order = Order::where('user_id', $user->id)->where('status', 0)->first();

        if (!$order) {
            $order = new Order();
            $order->user_id = $user->id;
            $order->total = 0;
            $order->status = 0;
            $order->city = '';
            $order->address = '';
            $order->phone = '';
            $order->save();
        }

        $orderItem = OrderItems::where('order_id', $order->id)
            ->where('product_id', $product->id)
            ->where('size_id', $request->size)
            ->where('color_id', $request->color)
            ->first();

        if (!$orderItem) {
            $orderItem = new OrderItems();
            $orderItem->order_id = $order->id;
            $orderItem->product_id = $product->id;
            $orderItem->product_name = $product->name;
            $orderItem->product_price = $product->price;
            $orderItem->image = $product->image;
            $orderItem->size_id = $request->size;
            $orderItem->color_id = $request->color;
            $orderItem->save();
            $message = 'Added to cart successfully!';
        } else {
            $message = 'Item already in cart!';
        }


        // $order->total += $orderItem->product_price;
        $order->save();

        return response()->json(['success' => true, 'message' => $message]);
    }

    public function saveQuantities(Request $request)
    {
        $orderItems = $request->input('order_items', []);

        foreach ($orderItems as $orderItemData) {
            $orderItem = OrderItems::find($orderItemData['itemId']);

            if ($orderItem) {
                $orderItem->quantity = $orderItemData['quantity'];
                $orderItem->save();
                $orderItem->order->total += $orderItem->product_price * $orderItemData['quantity'];
                $orderItem->order->save();
            }
        }
        return response()->json(['message' => 'Quantities updated successfully', 'data' => $orderItems]);
    }


    public function remove($id)
    {
        $orderItem = OrderItems::find($id);
        $order = Order::find($orderItem->order_id);
        $order->total -= $orderItem->product_price * $orderItem->quantity;
        $order->save();
        $orderItem->delete();

        return redirect()->route('customer.order.home')->with('success', 'Item removed from cart successfully');
    }

    public function checkout()
    {
        $user = auth()->user();
        $order = Order::where('user_id', $user->id)->where('status', 0)->first();
        $order->status = 1;
        $order->save();
        $orderItems = OrderItems::where('order_id', $order->id)->get();

        foreach ($orderItems as $item) {
            $product = Product::find($item->product_id);
            // $product->inventory -= $item->quantity;
            // $product->save();
            $color = Color::find($item->color_id);
            $size = Size::find($item->size_id);

            $inventory = Inventory::where('product_id', $product->id)
                ->where('color_id', $color->id)
                ->where('size_id', $size->id)
                ->first();

            $inventory->quantity -= $item->quantity;
            $inventory->save();
        }


        $name = auth()->user()->name;
        $email = auth()->user()->email;
        $id = $order->id;
        $total = $order->total;
        $orderDetailLink = '<a href="' . route('customer.order.orderdetail', ['order' => $order->id]) . '">View Order Details</a>';
        $orderCustomer = EmailTemplate::CustomerCode;


        $replacements = [
            'name' => $name,
            'id' => $id,
            'total' => $total,
            'link' => $orderDetailLink
        ];

        MailHelper::sendTemplateMail($orderCustomer, $email, $replacements);

        $admins = Admin::all();
        Notification::send($admins, new OrderPlaced($order));

        session()->flash('success', 'Order placed successfully. Check your email for confirmation');
        return redirect()->route('customer.order.home')->with('success', 'Order placed successfully. Check your email for confirmation');
    }

    public function reorder(Order $order)
    {
        $user = auth()->user();
        $reorder = Order::where('user_id', $user->id)->where('status', 0)->first();


        if ($reorder) {
            $reorder->total += $order->total;
            $reorder->save();
        } else {
            $reorder = new Order();
            $reorder->user_id = $user->id;
            $reorder->total = $order->total;
            $reorder->status = 0;
            $reorder->city = $order->city;
            $reorder->address = $order->address;
            $reorder->phone = $order->phone;
            $reorder->save();
        }

        $orderItems = $order->orderItems()->get();

        foreach ($orderItems as $item) {
            $orderItem = new OrderItems();
            $orderItem->order_id = $reorder->id;
            $orderItem->product_id = $item->product_id;
            $orderItem->product_name = $item->product_name;
            $orderItem->product_price = $item->product_price;
            $orderItem->image = $item->image;
            $orderItem->save();
        }


        session()->flash('success', 'Re Order items added to cart successfully.');
        return redirect()->route('customer.order.home')->with('success', 'Re Order items added to cart successfully.');
    }



    public function itemCount()
    {
        $user = auth()->user();
        $numberOfItems = 0;

        if ($user) {
            $order = Order::where('user_id', $user->id)->where('status', 0)->first();
            $numberOfItems = $order ? OrderItems::where('order_id', $order->id)->count() : 0;
        }

        return response()->json(['numberOfItems' => $numberOfItems]);
    }

    public function shippingSave(Order $order, Request $request)
    {
        $order->city = $request->city;
        $order->address = $request->address;
        $order->phone = $request->phone;
        $order->save();
        session()->flash('success', 'Shipping details saved successfully');
        return redirect()->route('customer.order.billing')->with('success', 'Shipping details saved successfully');
    }

    public function billingSave(Order $order, Request $request)
    {
        $order->city = $request->city;
        $order->address = $request->address;
        $order->phone = $request->phone;
        $order->billing_city = $request->city;
        $order->billing_address = $request->address;
        $order->bolling_phone = $request->phone;
        $order->save();
        session()->flash('success', 'Shipping and Billing details saved successfully');
        return redirect()->route('customer.order.checkoutpage')->with('success', 'Shipping and Billing details saved successfully');
    }

    public function history()
    {
        $user = auth()->user();
        $pendingorders = Order::where('user_id', $user->id)
            ->where('status', 1)
            ->where(function ($query) {
                $query->whereNull('refund')
                    ->orWhere('refund', 2);
            })
            ->get();

        $completedorders = Order::where('user_id', $user->id)->where('status', 2)->get();
        $refundorders = Order::where('user_id', $user->id)
            ->whereNotNull('refund')
            ->get();

        return view('customer.order.history', compact('pendingorders', 'completedorders', 'refundorders'));
    }

    public function orderdetail(Order $order)
    {
        $orderItems = OrderItems::where('order_id', $order->id)->get();
        $data = compact('order', 'orderItems');
        return view('customer.order.orderdetail', $data);
    }

    public function stripeCheckout(Request $request, Order $order)
    {
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));

        $redirectUrl = route('stripe.checkout.success') . '?session_id={CHECKOUT_SESSION_ID}&order_id=' . $order->id;

        $response = $stripe->checkout->sessions->create([
            'success_url' => $redirectUrl,

            'customer_email' => auth()->user()->email,

            'payment_method_types' => ['link', 'card'],

            'line_items' => [
                [
                    'price_data' => [
                        'product_data' => [
                            'name' => 'Order #' . $order->id,
                        ],
                        'unit_amount' => 100 *  $order->total,
                        'currency' => 'BDT',
                    ],
                    'quantity' => 1
                ],
            ],

            'mode' => 'payment',
            'allow_promotion_codes' => true,
        ]);



        return redirect($response['url']);
    }

    public function stripeCheckoutSuccess(Request $request)
    {
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));

        $response = $stripe->checkout->sessions->retrieve($request->session_id);
        $paymentIntent = $stripe->paymentIntents->retrieve($response->payment_intent);
        $charges = $stripe->charges->all(['payment_intent' => $paymentIntent->id]);
        $charge = $charges->data[0];

        $order = Order::find($request->order_id);
        $order->payment_method = "online";
        $order->save();

        $this->checkout();

        $paymentHistory = new PaymentHistory();
        $paymentHistory->order_id = $request->order_id;
        $paymentHistory->transaction_id = $charge->id;
        $paymentHistory->balance_transaction = $charge->balance_transaction;
        $paymentHistory->amount_total = $charge->amount / 100;
        $paymentHistory->payment_method = "Online Payment";
        $paymentHistory->payment_status = $charge->status;
        $paymentHistory->raw_response = json_encode($charge);
        $paymentHistory->receipt_url = $charge->receipt_url;
        $paymentHistory->save();
        return redirect()->route('customer.order.home', compact('response'))->with('success', 'Online payment done successfully. Check your email for confirmation');
    }

    public function cancel(Order $order)
    {
        $order->refund = 0;
        $order->save();
        session()->flash('success', 'Order cancelled successfully');
        return redirect()->route('customer.order.history')->with('success', 'Order cancelled successfully');
    }
}

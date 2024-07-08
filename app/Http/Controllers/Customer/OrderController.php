<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Admin;
use App\Models\OrderItems;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\MyEmail;
use App\Models\EmailTemplate;
use App\Helpers\MailHelper;
use App\Notifications\OrderPlaced;
use Illuminate\Support\Facades\Notification;
use App\Http\Controllers\AddressController; // Add this line

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



    public function add(Product $product)
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

        $orderItem = new OrderItems();
        $orderItem->order_id = $order->id;
        $orderItem->product_id = $product->id;
        $orderItem->product_name = $product->name;
        $orderItem->product_price = $product->price;
        $orderItem->save();

        $order->total += $orderItem->product_price;
        $order->save();

        $message = 'Added to cart successfully!';
        return response()->json(['success' => true, 'message' => $message]);
    }

    public function remove($id)
    {
        $orderItem = OrderItems::find($id);
        $order = Order::find($orderItem->order_id);
        $order->total -= $orderItem->product_price;
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
        $pendingorders = Order::where('user_id', $user->id)->where('status', 1)->get();
        $completedorders = Order::where('user_id', $user->id)->where('status', 2)->get();
        return view('customer.order.history', compact('pendingorders', 'completedorders'));
    }

    public function orderdetail(Order $order)
    {
        $orderItems = OrderItems::where('order_id', $order->id)->get();
        $data = compact('order', 'orderItems');
        return view('customer.order.orderdetail', $data);
    }
}

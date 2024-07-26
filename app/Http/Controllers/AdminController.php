<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Catagory;
use App\Models\Review;
use App\Models\Order;
use App\Models\OrderItems;
use App\Models\PaymentHistory;
use App\Models\EmailTemplate;
use App\Models\Color;
use App\Models\Inventory;
use App\Models\Size;
use App\Models\Images;
use Illuminate\Support\Facades\Notification;
use App\Notifications\OrderConfirmed;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalCategories = Catagory::count();
        $totalReviews = Review::count();
        $totalProducts = Product::count();
        $totalPendingOrders = Order::where('status', 1)->count();
        $totalCompletedOrders = Order::where('status', 2)->count();
        $totalTemplates = EmailTemplate::count();
        $totalPayments = PaymentHistory::count();
        $totalRefundRequests = Order::where('refund', 0)->count();
        $totalColors = Color::count();
        $totalSizes = Size::count();


        $unreadNotifications = auth()->user()->unreadNotifications;
        return view('admin.admin', compact('totalUsers', 'totalCategories', 'totalReviews', 'totalProducts', 'totalPendingOrders', 'totalCompletedOrders', 'totalTemplates', 'unreadNotifications', 'totalPayments', 'totalRefundRequests', 'totalColors', 'totalSizes'));
    }

    public function products()
    {
        $products = Product::all();
        return view('admin.products', compact('products'));
    }


    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $colors = Color::all();
        $sizes = Size::all();
        $inventories = Inventory::where('product_id', $id)->get();
        $combinations = [];
        foreach ($sizes as $size) {
            foreach ($colors as $color) {
                $combinations[] = [
                    'size_id' => $size->id,
                    'size_name' => $size->name,
                    'color_id' => $color->id,
                    'color_name' => $color->name,
                ];
            }
        }


        return view('admin.product.edit', compact('product', 'colors', 'sizes', 'combinations', 'inventories'));
    }
    public function updateProduct(Request $request, $id)
    {
        $request->validate([
            'image.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $product = Product::findOrFail($id);
        $product->name = $request->name;
        $product->description = $request->description;
        $product->prev_price = $product->price;
        $product->price = $request->price;
        $product->featured = $request->has('featured') ? 1 : 0;
        $product->new = $request->has('new') ? 1 : 0;
        $product->save();


        $destinationPath = config('utility.product_image_path');
        $images = $request->file('images');
        if ($images && is_array($images)) {
            foreach ($images as $key => $image) {
                if ($image) {
                    $imageName = time() . '_' . $key . '.' . $image->getClientOriginalExtension();
                    $image->storeAs($destinationPath, $imageName);

                    // Save the image details in the images table
                    $imageRecord = new Images();
                    $imageRecord->product_id = $product->id;
                    $imageRecord->path = $imageName;
                    $imageRecord->save();
                }
            }
        }

        foreach ($request->inventories as $inventoryData) {
            Inventory::updateOrCreate(
                [
                    'product_id' => $product->id,
                    'size_id' => $inventoryData['size_id'],
                    'color_id' => $inventoryData['color_id'],
                ],
                ['quantity' => $inventoryData['quantity']]
            );
        }

        return redirect()->back()->with('success', 'Product updated successfully', 2000);
    }

    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);
        //not needed for soft delete
        // $product->reviews()->delete();
        // $product->mappings()->delete();
        $product->delete();
        return redirect()->route('admin.products')->with('success', 'Product deleted successfully');
    }



    public function users()
    {
        $users = User::all();
        return view('admin.users', compact('users'));
    }

    public function categories()
    {
        $categories = Catagory::whereNull('parent_id')->get();
        $subcategories = Catagory::whereNotNull('parent_id')->get();
        return view('admin.categories', compact('categories', 'subcategories'));
    }

    public function reviews()
    {
        $reviews = Review::all();
        return view('admin.reviews', compact('reviews'));
    }

    public function pendingorders()
    {
        $orders = Order::where('status', 1)->get();
        return view('admin.pendingorders', compact('orders'));
    }

    public function completedorders()
    {
        $orders = Order::where('status', 2)->get();
        return view('admin.completedorders', compact('orders'));
    }

    public function refundorders()
    {
        $refundorders = Order::where('refund', 0)->get();
        return view('admin.refund', compact('refundorders'));
    }

    public function rejectrefund(Order $order)
    {
        $order->refund = 2;
        $order->save();
        return redirect()->back()->with('success', 'Refund request rejected successfully');
    }

    public function acceptrefund(Order $order)
    {
        if ($order->payment_method == 'cod') {
            $order->refund = 1;
            $order->save();
        } else if ($order->payment_method == 'online') {
            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
            $payment = PaymentHistory::where('order_id', $order->id)->first();
            $charge_id = $payment->transaction_id;
            $refund_amount = $payment->amount_total * 100;
            $refund = $stripe->refunds->create([
                'charge' => $charge_id,
                'amount' => $refund_amount,
                'reason' => 'requested_by_customer'
            ]);
            if ($refund->status == 'succeeded') {
                $order->refund = 1;
                $order->save();
            }
        }

        return redirect()->back()->with('success', 'Refund request accepted successfully');
    }

    public function orderdetail(Order $order)
    {
        $orderItems = OrderItems::where('order_id', $order->id)->get();
        $data = compact('order', 'orderItems');
        return view('admin.showorder', $data);
    }

    public function update(Order $order, Request $request)
    {
        $order->status = 2;
        $order->save();

        $user = $order->user;

        $existingNotification = $user->notifications()
            ->where('type', OrderConfirmed::class)
            ->where('data->order_id', $order->id)
            ->first();

        if (!$existingNotification) {
            Notification::send($user, new OrderConfirmed($order));
        }

        Log::info('Update method called for order: ' . $order->id);

        $previousRoute = $request->headers->get('referer');

        if ($previousRoute && str_contains($previousRoute, route('admin.order.show', $order->id))) {
            return redirect()->route('admin.admin')->with('success', 'Order status updated successfully');
        } else {
            return redirect()->back()->with('success', 'Order status updated successfully');
        }
    }
}

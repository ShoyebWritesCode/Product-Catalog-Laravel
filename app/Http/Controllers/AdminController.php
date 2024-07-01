<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Catagory;
use App\Models\Review;
use App\Models\Order;
use App\Models\OrderItems;
use App\Models\EmailTemplate;
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


        $unreadNotifications = auth()->user()->unreadNotifications;
        return view('admin.admin', compact('totalUsers', 'totalCategories', 'totalReviews', 'totalProducts', 'totalPendingOrders', 'totalCompletedOrders', 'totalTemplates', 'unreadNotifications'));
    }

    public function products()
    {
        $products = Product::all();
        return view('admin.products', compact('products'));
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

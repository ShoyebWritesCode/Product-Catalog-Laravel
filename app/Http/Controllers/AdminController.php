<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Catagory;
use App\Models\Review;
use App\Models\Order;

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
        return view('admin.admin', compact('totalUsers', 'totalCategories', 'totalReviews', 'totalProducts', 'totalPendingOrders', 'totalCompletedOrders'));
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
        return view('admin.categories',compact('categories','subcategories'));
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

    public function update(Order $order)
    {
        $order->status = 2;
        $order->save();
        return redirect()->back()->with('success', 'Order status updated successfully');
    }
}

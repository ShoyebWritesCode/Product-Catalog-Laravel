<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Catagory;
use App\Models\Review;

class HomeController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalCategories = Catagory::count();
        $totalReviews = Review::count();
        $totalProducts = Product::count();

        return view('admin.dashboard', compact('totalUsers', 'totalCategories', 'totalReviews', 'totalProducts'));
    }

    public function users()
    {
        $users = User::all();
        return view('admin.users', compact('users'));
    }
}

<?php

namespace App\Http\Controllers\Customer;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Catagory;
use Illuminate\Http\Request;

class CustomerProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $subcategories = Catagory::whereNotNull('parent_id')->get();
        $parentcategories = Catagory::whereNull('parent_id')->get();
        return view('customer.product.home',compact('products','subcategories','parentcategories'));
    }

    public function show(Product $product)
    {
        return view('customer.product.show', compact('product'));
    }
}

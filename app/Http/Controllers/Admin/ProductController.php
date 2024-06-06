<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Catagory;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $subcategories = Catagory::whereNotNull('parent_id')->get();
        $parentcategories = Catagory::whereNull('parent_id')->get();
        return view('admin.product.home',compact('products','subcategories','parentcategories'));
    }

    public function create()
    {
        $categories = Catagory::whereNull('parent_id')->get();
        $subcategories = Catagory::whereNotNull('parent_id')->get();
        return view('admin.product.create',compact('categories','subcategories'));
    }

    public function save(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'price' => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            // 'subcategory_of' => 'nullable|string|exists:catagories,name',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);

        $product = new Product();
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->image = $imageName;
        
        $subcategory = Catagory::where('id', $request->subcategory_of)->first();
        $product->catagory_id = $subcategory->id;
        $product->save();
        }
        session()->flash('success', 'Product created successfully');
        return redirect()->route('admin.product.home')->with('success', 'Product created successfully');
    } 


}
<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Catagory;
use App\Models\Mapping;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    // public function index()
    // {
    //     $products = Product::all();
    //     $subcategories = Catagory::whereNotNull('parent_id')->get();
    //     $parentcategories = Catagory::whereNull('parent_id')->get();
    //     return view('admin.product.home',compact('products','subcategories','parentcategories'));
    // }

    public function index()
    {
        $products = Product::all();
        $subcategories = [];
        $namesubcategories = [];
        $nameparentcategories = [];
    
  
        $categories = Catagory::all()->keyBy('id');
    
        foreach ($products as $product) {
            $subcategories[$product->id] = Mapping::where('product_id', $product->id)->pluck('catagory_id')->toArray();
    
            $namesubcategories[$product->id] = array_map(function($catagory_id) use ($categories) {
                return $categories[$catagory_id]->name ?? 'Unknown';
            }, $subcategories[$product->id]);

            $nameparentcategories[$product->id] = array_unique(array_map(function($catagory_id) use ($categories) {
                return $categories[$catagory_id]->parent->name ?? 'Unknown';
            }, $subcategories[$product->id]));
            
        }

        
    
        return view('admin.product.home', compact('products', 'namesubcategories', 'nameparentcategories'));
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
            $product->save();

            // Loop through subcategories and save mappings
            if ($request->has('subcategories')) {
                foreach ($request->subcategories as $subcategoryId) {
                    $mapping = new Mapping();
                    $mapping->product_id = $product->id;
                    $mapping->catagory_id = $subcategoryId;
                    $mapping->save();
                }
            }

            session()->flash('success', 'Product created successfully');
            return redirect()->route('admin.product.home')->with('success', 'Product created successfully');
        } else {
            session()->flash('error', 'Image upload failed');
            return redirect()->route('admin.product.create')->with('error', 'Image upload failed');
        }
    } 

    public function show(Product $product)
    {

        $subcategories = [];
        $namesubcategories = [];
        $nameparentcategories = [];
    
  
        $categories = Catagory::all()->keyBy('id');
 
            $subcategories[$product->id] = Mapping::where('product_id', $product->id)->pluck('catagory_id')->toArray();
    
            $namesubcategories[$product->id] = array_map(function($catagory_id) use ($categories) {
                return $categories[$catagory_id]->name ?? 'Unknown';
            }, $subcategories[$product->id]);

            $nameparentcategories[$product->id] = array_unique(array_map(function($catagory_id) use ($categories) {
                return $categories[$catagory_id]->parent->name ?? 'Unknown';
            }, $subcategories[$product->id]));
            
    return view('admin.product.show', compact('product', 'namesubcategories', 'nameparentcategories'));
}


}
<?php

namespace App\Http\Controllers\Customer;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Catagory;
use App\Models\Mapping;
use Illuminate\Http\Request;

class CustomerProductController extends Controller
{
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

        
    
        return view('customer.product.home', compact('products', 'namesubcategories', 'nameparentcategories'));
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

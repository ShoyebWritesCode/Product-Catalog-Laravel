<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Catagory;
use App\Models\Mapping;
use App\Models\Images;
use App\Models\Inventory;
use App\Models\ProductAttribute;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Review;

class ProductController extends Controller
{

    public function index()
    {
        $products = Product::all();
        $subcategories = [];
        $namesubcategories = [];
        $nameparentcategories = [];
        $averageRatings = [];


        $categories = Catagory::all()->keyBy('id');

        foreach ($products as $product) {
            $subcategories[$product->id] = Mapping::where('product_id', $product->id)->pluck('catagory_id')->toArray();

            $namesubcategories[$product->id] = array_map(function ($catagory_id) use ($categories) {
                return $categories[$catagory_id]->name ?? 'Unknown';
            }, $subcategories[$product->id]);

            $nameparentcategories[$product->id] = array_unique(array_map(function ($catagory_id) use ($categories) {
                return $categories[$catagory_id]->parent->name ?? 'Unknown';
            }, $subcategories[$product->id]));

            $averageRatings[$product->id] = Review::where('product_id', $product->id)->avg('rating');
        }



        return view('admin.product.home', compact('products', 'namesubcategories', 'nameparentcategories', 'averageRatings'));
    }


    public function create()
    {
        $categories = Catagory::whereNull('parent_id')->get();
        $subcategories = Catagory::whereNotNull('parent_id')->get();
        return view('admin.product.create', compact('categories', 'subcategories'));
    }

    public function save(Request $request)
    {
        $request->validate($this->validationRules());

        $product = $this->createProduct($request);

        if ($request->has('subcategories')) {
            $this->attachSubcategories($product->id, $request->subcategories);
        }

        $this->handleImageUpload($request, $product->id);

        session()->flash('success', 'Product created successfully');
        return redirect()->route('admin.products')->with('success', 'Product created successfully');
    }

    public function updateProduct(Request $request, $id)
    {
        $request->validate($this->updateValidationRules());

        $product = Product::findOrFail($id);
        $this->updateProductDetails($product, $request);

        $this->handleImageUpload($request, $product->id);

        $this->updateInventories($request->inventories, $product->id);

        $this->updateSpecifications($request->product_attributes, $product->id);

        return redirect()->back()->with('success', 'Product updated successfully');
    }

    private function validationRules()
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'price' => 'required|numeric',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }

    private function updateValidationRules()
    {
        return [
            'images.*' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }

    private function createProduct(Request $request)
    {
        $product = new Product();
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->save();

        return $product;
    }

    private function attachSubcategories($productId, array $subcategories)
    {
        foreach ($subcategories as $subcategoryId) {
            $mapping = new Mapping();
            $mapping->product_id = $productId;
            $mapping->catagory_id = $subcategoryId;
            $mapping->save();
        }
    }

    private function handleImageUpload(Request $request, $productId)
    {
        $destinationPath = config('utility.product_image_path');
        $images = $request->file('images');

        if ($images && is_array($images)) {
            foreach ($images as $key => $image) {
                if ($image) {
                    $imageName = time() . '_' . $key . '.' . $image->getClientOriginalExtension();
                    $image->storeAs($destinationPath, $imageName);

                    // Save the image details in the images table
                    $imageRecord = new Images();
                    $imageRecord->product_id = $productId;
                    $imageRecord->path = $imageName;
                    $imageRecord->save();
                }
            }
        } else {
            // session()->flash('error', 'Image upload failed');
            return redirect()->route('admin.product.create');
            // ->with('error', 'Image upload failed');
        }
    }

    private function updateProductDetails(Product $product, Request $request)
    {
        $product->name = $request->name;
        $product->description = $request->description;
        $product->Detailes = $request->details;
        if ($request->price != $product->price) {
            $product->prev_price = $product->price;
            $product->price = $request->price;
        }
        $product->slug = $request->slug;
        $product->featured = $request->has('featured') ? 1 : 0;
        $product->new = $request->has('new') ? 1 : 0;

        $product->save();
    }

    private function updateInventories(array $inventories, $productId)
    {
        foreach ($inventories as $inventoryData) {
            Inventory::updateOrCreate(
                [
                    'product_id' => $productId,
                    'size_id' => $inventoryData['size_id'],
                    'color_id' => $inventoryData['color_id'],
                ],
                ['quantity' => $inventoryData['quantity']]
            );
        }
    }

    private function updateSpecifications(array $product_attributes, $productId)
    {
        foreach ($product_attributes as $attributeData) {
            if (!is_null($attributeData['value'])) {
                ProductAttribute::updateOrCreate(
                    [
                        'product_id' => $productId,
                        'attribute_id' => $attributeData['attribute_id'],
                    ],
                    ['value' => $attributeData['value']]
                );
            }
        }
    }

    public function show(Product $product)
    {

        $subcategories = [];
        $namesubcategories = [];
        $nameparentcategories = [];
        $averageRatings = [];


        $categories = Catagory::all()->keyBy('id');

        $subcategories[$product->id] = Mapping::where('product_id', $product->id)->pluck('catagory_id')->toArray();

        $namesubcategories[$product->id] = array_map(function ($catagory_id) use ($categories) {
            return $categories[$catagory_id]->name ?? 'Unknown';
        }, $subcategories[$product->id]);

        $nameparentcategories[$product->id] = array_unique(array_map(function ($catagory_id) use ($categories) {
            return $categories[$catagory_id]->parent->name ?? 'Unknown';
        }, $subcategories[$product->id]));

        $reviews = Review::where('product_id', $product->id)->get();
        $averageRatings[$product->id] = Review::where('product_id', $product->id)->avg('rating');

        return view('admin.product.show', compact('product', 'namesubcategories', 'nameparentcategories', 'reviews', 'averageRatings'));
    }
}

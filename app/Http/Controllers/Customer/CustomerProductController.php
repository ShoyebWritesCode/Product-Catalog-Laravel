<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Review;
use App\Models\Catagory;
use App\Models\Mapping;
use Illuminate\Http\Request;

class CustomerProductController extends Controller
{
    public function index()
    {
        // $products = Product::paginate(10);
        $initialProducts = Product::take(10)->get();
        $subcategories = [];
        $namesubcategories = [];
        $nameparentcategories = [];
        $averageRatings = [];
        $discountPercent = [];
        $allParentCategories = [];
        $allChildCategoriesOfParent = [];


        $categories = Catagory::all()->keyBy('id');
        $allParentCategories = Catagory::where('parent_id', null)->get();
        foreach ($allParentCategories as $parentCategory) {
            $allChildCategoriesOfParent[$parentCategory->id] = Catagory::where('parent_id', $parentCategory->id)->get();
        }

        foreach ($initialProducts as $product) {
            $subcategories[$product->id] = Mapping::where('product_id', $product->id)->pluck('catagory_id')->toArray();

            $namesubcategories[$product->id] = array_map(function ($catagory_id) use ($categories) {
                return $categories[$catagory_id]->name ?? 'Unknown';
            }, $subcategories[$product->id]);

            $nameparentcategories[$product->id] = array_unique(array_map(function ($catagory_id) use ($categories) {
                return $categories[$catagory_id]->parent->name ?? 'Unknown';
            }, $subcategories[$product->id]));

            $averageRatings[$product->id] = Review::where('product_id', $product->id)->avg('rating');

            if ($product->prev_price && $product->price < $product->prev_price) {
                $discountPercent[$product->id] = (($product->prev_price - $product->price) / $product->prev_price) * 100;
                $discountPercent[$product->id] = round($discountPercent[$product->id], 2);
            } else {
                $discountPercent[$product->id] = null;
            }
        }

        $unreadNotifications = auth()->user()->unreadNotifications;

        return view('customer.product.home', compact('initialProducts', 'namesubcategories', 'nameparentcategories', 'averageRatings', 'unreadNotifications', 'discountPercent', 'allParentCategories', 'allChildCategoriesOfParent'));
    }

    public function fetchProducts(Request $request)
    {
        $page = $request->get('page', 1);
        $perPage = 10;

        $products = Product::skip(($page - 1) * $perPage)
            ->take($perPage)
            ->get();

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

        return view('partials.products', compact('products', 'namesubcategories', 'nameparentcategories', 'averageRatings'));
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

        return view('customer.product.show', compact('product', 'namesubcategories', 'nameparentcategories', 'reviews', 'averageRatings'));
    }

    public function search(Request $request)
    {
        $search = $request->input('search');


        $products = Product::where(function ($query) use ($search) {
            $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('description', 'like', '%' . $search . '%')
                ->orWhere('price', 'like', '%' . $search . '%');
        })
            ->get();



        return view('customer.product.search', [
            'products' => $products,
            'search' => $search,
        ]);
    }

    public function categoryProducts(Catagory $category)
    {

        $selectedCategory = $category;
        $childrenCategories = Catagory::where('parent_id', $category->id)->get()->keyBy('id');
        $Products = [];
        $subcategories = [];
        $namesubcategories = [];
        $nameparentcategories = [];
        $averageRatings = [];
        $discountPercent = [];
        foreach ($childrenCategories as $childCategory) {
            $mappings = Mapping::where('catagory_id', $childCategory->id)->get();
            foreach ($mappings as $mapping) {
                $Products[] = Product::find($mapping->product_id);
            }
        }

        $allParentCategories = [];
        $allChildCategoriesOfParent = [];


        $categories = Catagory::all()->keyBy('id');
        $allParentCategories = Catagory::where('parent_id', null)->get();
        foreach ($allParentCategories as $parentCategory) {
            $allChildCategoriesOfParent[$parentCategory->id] = Catagory::where('parent_id', $parentCategory->id)->get();
        }


        foreach ($Products as $product) {
            $subcategories[$product->id] = Mapping::where('product_id', $product->id)->pluck('catagory_id')->toArray();

            $namesubcategories[$product->id] = array_map(function ($catagory_id) use ($childrenCategories) {
                return $childrenCategories[$catagory_id]->name ?? 'Unknown';
            }, $subcategories[$product->id]);

            $averageRatings[$product->id] = Review::where('product_id', $product->id)->avg('rating');

            if ($product->prev_price && $product->price < $product->prev_price) {
                $discountPercent[$product->id] = (($product->prev_price - $product->price) / $product->prev_price) * 100;
                $discountPercent[$product->id] = round($discountPercent[$product->id], 2);
            } else {
                $discountPercent[$product->id] = null;
            }
        }

        $unreadNotifications = auth()->user()->unreadNotifications;

        // return response()->json($namesubcategories);

        return view('customer.category.products', compact('Products', 'selectedCategory', 'namesubcategories', 'averageRatings', 'unreadNotifications', 'discountPercent', 'allParentCategories', 'allChildCategoriesOfParent'));
    }
}

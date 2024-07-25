<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Review;
use App\Models\Catagory;
use App\Models\Color;
use App\Models\Mapping;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class CustomerProductController extends Controller
{
    public function getProductData()
    {
        $initialProducts = Product::take(10)->get();
        $featuredProducts = Product::where('featured', true)->get();
        $newProducts = Product::where('new', true)->get();
        $discountedProducts = $initialProducts->random(10);
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

        return compact('initialProducts', 'namesubcategories', 'nameparentcategories', 'averageRatings', 'unreadNotifications', 'discountPercent', 'allParentCategories', 'allChildCategoriesOfParent', 'featuredProducts', 'newProducts', 'discountedProducts');
    }

    public function index()
    {
        $data = $this->getProductData();
        return view('customer.product.home', $data);
    }

    public function featuredProducts()
    {
        $data = $this->getProductData();
        return view('customer.product.featuredproducts', $data);
    }

    public function newProducts()
    {
        $data = $this->getProductData();
        return view('customer.product.newproducts', $data);
    }

    public function allProducts()
    {
        $data = $this->getProductData();
        return view('customer.product.allproducts', $data);
    }

    public function navindex()
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

        return view('partials.nav', compact('initialProducts', 'namesubcategories', 'nameparentcategories', 'averageRatings', 'unreadNotifications', 'discountPercent', 'allParentCategories', 'allChildCategoriesOfParent'));
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
        $colors = Color::all();
        $sizes = Size::all();
        $allParentCategories = [];


        $categories = Catagory::all()->keyBy('id');
        $allParentCategories = Catagory::where('parent_id', null)->get();
        foreach ($allParentCategories as $parentCategory) {
            $allChildCategoriesOfParent[$parentCategory->id] = Catagory::where('parent_id', $parentCategory->id)->get();
        }

        $subcategories[$product->id] = Mapping::where('product_id', $product->id)->pluck('catagory_id')->toArray();

        $namesubcategories[$product->id] = array_map(function ($catagory_id) use ($categories) {
            return $categories[$catagory_id]->name ?? 'Unknown';
        }, $subcategories[$product->id]);

        $nameparentcategories[$product->id] = array_unique(array_map(function ($catagory_id) use ($categories) {
            return $categories[$catagory_id]->parent->name ?? 'Unknown';
        }, $subcategories[$product->id]));

        $reviews = Review::where('product_id', $product->id)->get();
        $averageRatings[$product->id] = Review::where('product_id', $product->id)->avg('rating');
        $unreadNotifications = auth()->user()->unreadNotifications;

        return view('customer.product.show', compact('product', 'namesubcategories', 'nameparentcategories', 'reviews', 'averageRatings', 'colors', 'sizes', 'allParentCategories', 'allChildCategoriesOfParent', 'unreadNotifications'));
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

    public function categoryProducts(Request $request, Catagory $category)
    {
        // Retrieve filter parameters from the request
        $childCategory = $request->input('child_category');
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');
        $color = $request->input('color');

        $selectedCategory = $category;
        $childrenCategories = Catagory::where('parent_id', $category->id)->get()->keyBy('id');

        // Fetch all products and apply filters
        $Products = Product::whereHas('mappings', function ($query) use ($childrenCategories, $childCategory) {
            $query->whereIn('catagory_id', $childrenCategories->pluck('id'));
            if ($childCategory) {
                $query->where('catagory_id', $childCategory);
            }
        });

        if ($minPrice) {
            $Products->where('price', '>=', $minPrice);
        }

        if ($maxPrice) {
            $Products->where('price', '<=', $maxPrice);
        }

        if ($color) {
            $Products->where('color', $color);
        }

        $Products = $Products->get();

        $subcategories = [];
        $namesubcategories = [];
        $nameparentcategories = [];
        $averageRatings = [];
        $discountPercent = [];
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

        $allParentCategories = Catagory::where('parent_id', null)->get();
        $allChildCategoriesOfParent = [];
        foreach ($allParentCategories as $parentCategory) {
            $allChildCategoriesOfParent[$parentCategory->id] = Catagory::where('parent_id', $parentCategory->id)->get();
        }

        $collection = new Collection($Products);
        $perPage = 12;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentPageItems = $collection->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $paginator = new LengthAwarePaginator($currentPageItems, $collection->count(), $perPage, $currentPage, [
            'path' => LengthAwarePaginator::resolveCurrentPath(),
        ]);

        return view('customer.category.products', [
            'countProducts' => count($Products),
            'Products' => $paginator,
            'selectedCategory' => $selectedCategory,
            'namesubcategories' => $namesubcategories,
            'averageRatings' => $averageRatings,
            'unreadNotifications' => $unreadNotifications,
            'discountPercent' => $discountPercent,
            'allParentCategories' => $allParentCategories,
            'allChildCategoriesOfParent' => $allChildCategoriesOfParent,
        ]);
    }

    public function sortProducts(Request $request, Catagory $category)
    {
        $selectedCategory = $category;
        $childrenCategories = Catagory::where('parent_id', $category->id)->get()->keyBy('id');


        $sort = $request->input('sort', 'name');

        // $query = Product::query();

        $Products = Product::whereHas('mappings', function ($query) use ($childrenCategories) {
            $query->whereIn('catagory_id', $childrenCategories->pluck('id'));
        });

        switch ($sort) {
            case 'price':
                $Products->orderBy('price');
                break;
            case 'name':
            default:
                $Products->orderBy('name');
                break;
        }

        // return response()->json($Products->get());

        $products = $Products->paginate(12);

        // Prepare additional data for the view
        $allParentCategories = Catagory::where('parent_id', null)->get();
        $allChildCategoriesOfParent = [];
        foreach ($allParentCategories as $parentCategory) {
            $allChildCategoriesOfParent[$parentCategory->id] = Catagory::where('parent_id', $parentCategory->id)->get();
        }

        $unreadNotifications = auth()->user()->unreadNotifications;

        return view('customer.category.products', [
            'countProducts' => $products->total(),
            'Products' => $products,
            'selectedCategory' => $selectedCategory,
            'allParentCategories' => $allParentCategories,
            'allChildCategoriesOfParent' => $allChildCategoriesOfParent,
            'unreadNotifications' => $unreadNotifications,
        ]);
    }
}

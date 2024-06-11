<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\CatagoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Customer\CustomerProductController;
use App\Http\Controllers\Customer\ReviewController;
use App\Http\Middleware\Admin;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/products', [CustomerProductController::class, 'index'])->name('customer.product.home');
    Route::get('/products/{product}', [CustomerProductController::class, 'show'])->name('customer.product.show');
    Route::post('/products/{product}/reviews', [ReviewController::class, 'store'])->name('customer.product.reviews');

});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [HomeController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/users', [HomeController::class, 'users'])->name('admin.users');


    Route::get('/admin/catagories', [CatagoryController::class, 'index'])->name('admin.catagory.home');
    Route::get('/admin/catagories/create', [CatagoryController::class, 'create'])->name('admin.catagory.create');
    Route::post('/admin/catagories/save', [CatagoryController::class, 'save'])->name('admin.catagory.save');

    Route::get('/admin/products', [ProductController::class, 'index'])->name('admin.product.home');
    Route::get('/admin/products/create', [ProductController::class, 'create'])->name('admin.product.create');
    Route::post('/admin/products/save', [ProductController::class, 'save'])->name('admin.product.save');
    Route::get('/admin/products/{product}', [ProductController::class, 'show'])->name('admin.product.show');
    Route::get('admin/admin',[AdminController::class,'index'])->name('admin.admin');
    Route::get('admin/admin/products',[AdminController::class,'products'])->name('admin.products');
    Route::get('admin/admin/users',[AdminController::class,'users'])->name('admin.users');
    Route::get('admin/admin/categories',[AdminController::class,'categories'])->name('admin.categories');
    Route::get('admin/admin/reviews',[AdminController::class,'reviews'])->name('admin.reviews');

    
});	

require __DIR__.'/auth.php';

// Route::get('admin/dashboard', [HomeController::class, 'index'])->middleware(['auth', 'verified','admin'])->name('admin.dashboard');

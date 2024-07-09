<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\CatagoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Customer\CustomerProductController;
use App\Http\Controllers\Customer\ReviewController;
use App\Http\Controllers\Customer\OrderController;
use App\Http\Middleware\Admin;
use App\Mail\MyEmail;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\EmailTemplateController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\NotificationController as ControllersNotificationController;
use App\Http\Controllers\ChartController;
use App\Models\Address;
use App\Http\Controllers\AddressController;

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
    Route::patch('/profile/shippingaddress', [AddressController::class, 'addAddress'])->name('profile.shippingaddress');
    Route::patch('/profile/billingaddress', [AddressController::class, 'addBillingAddress'])->name('profile.billingaddress');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::get('/products', [CustomerProductController::class, 'index'])->name('customer.product.home');
    Route::post('/products/notifications/mark-as-read/{id}', [NotificationController::class, 'markAsReadCus'])->name('customer.notifications.markAsRead');
    Route::get('/products/fetch', [CustomerProductController::class, 'fetchProducts'])->name('customer.product.fetch');
    Route::get('/products/search', [CustomerProductController::class, 'search'])->name('customer.product.search');
    Route::get('/products/{product}', [CustomerProductController::class, 'show'])->name('customer.product.show');
    Route::post('/products/{product}/reviews', [ReviewController::class, 'store'])->name('customer.product.reviews');
    Route::get('/orders', [OrderController::class, 'index'])->name('customer.order.home');
    Route::get('/orders/shipping', [OrderController::class, 'shipping'])->name('customer.order.shipping');
    Route::post('/orders/shipping/{order}', [OrderController::class, 'shippingSave'])->name('customer.order.shipping.save');
    Route::get('/orders/billing', [OrderController::class, 'billing'])->name('customer.order.billing');
    Route::post('/orders/billing/{order}', [OrderController::class, 'billingSave'])->name('customer.order.billing.save');
    Route::get('/order/sameaddr/{id}', [OrderController::class, 'getShippingAddress'])->name('customer.order.sameaddr');
    Route::get('/orderpopup', [OrderController::class, 'popup'])->name('customer.order.popup');
    Route::post('/orders/{product}', [OrderController::class, 'add'])->name('customer.order.add');
    Route::delete('/orders/{id}', [OrderController::class, 'remove'])->name('cart.remove');
    Route::get('/orders/checkout', [OrderController::class, 'checkoutpage'])->name('customer.order.checkoutpage');
    Route::post('/orders/checkout/{order}', [OrderController::class, 'checkout'])->name('customer.order.checkout');
    Route::post('/orders/checkout/stripe/{order}', [OrderController::class, 'stripeCheckout'])->name('customer.order.stripe');
    Route::get('/orders/checkout/stripe/success', [OrderController::class, 'stripeCheckoutSuccess'])->name('stripe.checkout.success');
    Route::post('/orders/reorder/{order}', [OrderController::class, 'reorder'])->name('customer.order.reorder');
    Route::get('/history', [OrderController::class, 'history'])->name('customer.order.history');
    Route::get('/history/{order}', [OrderController::class, 'orderdetail'])->name('customer.order.orderdetail');
    // Route::get('/email', [EmailController::class, 'sendEmail'])->name('email.send');
    // Route::get('/order/cart', [OrderController::class, 'itemCount'])->name('customer.order.cart');

});

Route::middleware(['auth:admin'])->group(function () {
    Route::get('/admin/dashboard', [HomeController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/users', [HomeController::class, 'users'])->name('admin.users');


    Route::get('/admin/catagories', [CatagoryController::class, 'index'])->name('admin.catagory.home');
    Route::get('/admin/catagories/create', [CatagoryController::class, 'create'])->name('admin.catagory.create');
    Route::post('/admin/catagories/save', [CatagoryController::class, 'save'])->name('admin.catagory.save');

    Route::get('/admin/products', [ProductController::class, 'index'])->name('admin.product.home');
    Route::get('/admin/products/create', [ProductController::class, 'create'])->name('admin.product.create');
    Route::post('/admin/products/save', [ProductController::class, 'save'])->name('admin.product.save');
    Route::get('/admin/products/{product}', [ProductController::class, 'show'])->name('admin.product.show');
    Route::get('admin/admin', [AdminController::class, 'index'])->name('admin.admin');
    Route::get('admin/admin/products', [AdminController::class, 'products'])->name('admin.products');
    Route::get('/admin/admin/product/edit/{id}', [AdminController::class, 'edit'])->name('admin.product.edit');
    Route::put('/admin/admin/product/update/{id}', [AdminController::class, 'updateProduct'])->name('admin.product.update');
    Route::delete('/admin/admin/product/update/{id}', [AdminController::class, 'deleteProduct'])->name('admin.product.delete');
    Route::get('admin/admin/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('admin/admin/categories', [AdminController::class, 'categories'])->name('admin.categories');
    Route::get('admin/admin/reviews', [AdminController::class, 'reviews'])->name('admin.reviews');
    Route::get('admin/admin/pendingorders', [AdminController::class, 'pendingorders'])->name('admin.pendingorders');
    Route::post('admin/admin/pendingorders/{order}', [AdminController::class, 'update'])->name('admin.pendingorders.update');
    Route::get('admin/admin/completedorders', [AdminController::class, 'completedorders'])->name('admin.completedorders');
    Route::post('/admin/admin/notifications/mark-as-read/{id}', [NotificationController::class, 'markAsReadCus'])->name('admin.notifications.markAsRead');
    Route::get('/admin/admin/notifications/mark-as-read', [NotificationController::class, 'markAsRead'])->name('admin.notifications.markAllAsRead');
    Route::delete('/admin/admin/notifications/{notification}', [NotificationController::class, 'delete'])->name('admin.notifications.delete');
    Route::get('/admin/admin/notifications/delete', [NotificationController::class, 'deleteAll'])->name('admin.notifications.deleteAll');
    Route::get('admin/admin/notifications', [NotificationController::class, 'index'])->name('admin.notifications.index');

    Route::get('/admin/admin/order/{order}', [AdminController::class, 'orderdetail'])->name('admin.order.show');
    // Route::get('admin/admin/templates/create', [TemplateController::class, 'create'])->name('admin.templates.create');
    Route::get('admin/admin/templates', [EmailTemplateController::class, 'index'])->name('admin.templates.index');
    Route::get('/templates/{template}/edit', [EmailTemplateController::class, 'edit'])->name('admin.templates.create');
    Route::put('/templates/{template}', [EmailTemplateController::class, 'update'])->name('admin.templates.update');
    Route::post('admin/admin/templates/store', [EmailTemplateController::class, 'store'])->name('admin.templates.store');
    Route::post('admin/admin/templates/placeholders', [EmailTemplateController::class, 'addPlaceholder'])->name('admin.placeholders.add');
    // Route::post('/admin/admin/notifications/mark-as-read', [NotificationController::class, 'markAsRead'])->name('admin.notifications.markAsRead');

    Route::get('admin/admin/charts', [ChartController::class, 'index'])->name('admin.charts.index');
});

require __DIR__ . '/auth.php';

// Route::get('admin/dashboard', [HomeController::class, 'index'])->middleware(['auth', 'verified','admin'])->name('admin.dashboard');

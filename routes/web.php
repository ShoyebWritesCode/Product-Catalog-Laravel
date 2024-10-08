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
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\PaymentHistoryController;
use App\Models\Inventory;
use App\Http\Controllers\PushNotificationController;


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
    Route::get('/products/all', [CustomerProductController::class, 'allProducts'])->name('customer.product.all');
    Route::get('/products/featured', [CustomerProductController::class, 'featuredProducts'])->name('customer.product.featured');
    Route::get('/products/new', [CustomerProductController::class, 'newProducts'])->name('customer.product.new');
    Route::get('/navbar', [CustomerProductController::class, 'navindex'])->name('customer.navbar');
    Route::post('/products/notifications/mark-as-read/{id}', [NotificationController::class, 'markAsReadCus'])->name('customer.notifications.markAsRead');
    Route::get('/products/fetch', [CustomerProductController::class, 'fetchProducts'])->name('customer.product.fetch');
    Route::get('/products/search', [CustomerProductController::class, 'search'])->name('customer.product.search');
    Route::get('/products/{product}/{slug?}', [CustomerProductController::class, 'show'])->name('customer.product.show');
    Route::post('/products/{product}/reviews', [ReviewController::class, 'store'])->name('customer.product.reviews');
    Route::get('/orders', [OrderController::class, 'index'])->name('customer.order.home');
    Route::get('/cart/count', [OrderController::class, 'itemCount'])->name('cart.count');
    Route::get('/orders/shipping', [OrderController::class, 'shipping'])->name('customer.order.shipping');
    Route::post('/orders/shipping/{order}', [OrderController::class, 'shippingSave'])->name('customer.order.shipping.save');
    Route::get('/orders/billing', [OrderController::class, 'billing'])->name('customer.order.billing');
    Route::post('/orders/billing/{order}', [OrderController::class, 'billingSave'])->name('customer.order.billing.save');
    Route::get('/order/sameaddr/{id}', [OrderController::class, 'getShippingAddress'])->name('customer.order.sameaddr');
    Route::get('/orderpopup', [OrderController::class, 'popup'])->name('customer.order.popup');
    Route::post('/orders/{product}', [OrderController::class, 'add'])->name('customer.order.add');
    Route::delete('/orders/{id}', [OrderController::class, 'remove'])->name('cart.remove');
    Route::get('/orders/checkout', [OrderController::class, 'checkoutpage'])->name('customer.order.checkoutpage');
    Route::post('/orders/checkout/cod/{order}', [OrderController::class, 'checkout'])->name('customer.order.checkout');

    Route::post('/stripe-checkout/{order}', [OrderController::class, 'showPaymentForm'])->name('customer.native.checkout');
    Route::post('/create-payment-intent', [OrderController::class, 'createPaymentIntent'])->name('create-payment-intent');
    Route::post('/payment-success', [OrderController::class, 'handlePaymentSuccess'])
        ->name('handle-payment-success');

    Route::post('/orders/checkout/stripe/{order}', [OrderController::class, 'stripeCheckout'])->name('customer.order.stripe');
    Route::get('/orders/checkout/stripe/success', [OrderController::class, 'stripeCheckoutSuccess'])->name('stripe.checkout.success');
    Route::post('/orders/reorder/{order}', [OrderController::class, 'reorder'])->name('customer.order.reorder');
    Route::get('/history', [OrderController::class, 'history'])->name('customer.order.history');
    Route::get('/history/{order}', [OrderController::class, 'orderdetail'])->name('customer.order.orderdetail');
    Route::get('/order/cancel/{order}', [OrderController::class, 'cancel'])->name('customer.order.cancel');
    Route::get('category/products/{category}/filter', [CustomerProductController::class, 'categoryProducts'])->name('customer.category.products');
    Route::get('category/products/{childCategory}', [CustomerProductController::class, 'subcategoryProducts'])->name('customer.subcategory.products');
    Route::get('category/products/{category}/sort', [CustomerProductController::class, 'sortProducts'])->name('customer.products.sort');
    Route::post('orders/save/quantities', [OrderController::class, 'saveQuantities'])->name('customer.order.saveQuantities');
    Route::get('product/inventory/quantity', [InventoryController::class, 'getInventoryQuantity'])->name('product.inventory.quantity');
});

Route::middleware(['auth:admin'])->group(function () {
    // Route::get('/admin/dashboard', [HomeController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/users', [HomeController::class, 'users'])->name('admin.users');


    // Route::get('/admin/catagories', [CatagoryController::class, 'index'])->name('admin.catagory.home');
    Route::get('/admin/catagories/create', [CatagoryController::class, 'create'])->name('admin.catagory.create');
    Route::post('/admin/catagories/save', [CatagoryController::class, 'save'])->name('admin.catagory.save');

    // Route::get('/admin/products', [ProductController::class, 'index'])->name('admin.product.home');
    Route::get('/admin/products/create', [ProductController::class, 'create'])->name('admin.product.create');
    Route::post('/admin/products/save', [ProductController::class, 'save'])->name('admin.product.save');
    Route::get('/admin/products/{product}', [ProductController::class, 'show'])->name('admin.product.show');
    Route::get('admin', [AdminController::class, 'index'])->name('admin.admin');
    Route::get('admin/products', [AdminController::class, 'products'])->name('admin.products');
    Route::get('/admin/product/edit/{id}', [AdminController::class, 'edit'])->name('admin.product.edit');
    Route::put('/admin/product/update/{id}', [ProductController::class, 'updateProduct'])->name('admin.product.update');
    Route::delete('/admin/product/update/{id}', [AdminController::class, 'deleteProduct'])->name('admin.product.delete');
    Route::get('admin/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('admin/categories', [AdminController::class, 'categories'])->name('admin.categories');
    Route::get('admin/categories/edit/{id}', [AdminController::class, 'categoryEdit'])->name('admin.category.edit');
    Route::put('/admin/categories/update/{id}', [AdminController::class, 'updateCategory'])->name('admin.category.update');
    Route::get('/admin/attributes', [AdminController::class, 'attributes'])->name('admin.attributes');
    Route::post('/admin/attributes/save', [AdminController::class, 'attributesStore'])->name('admin.attributes.store');
    Route::get('admin/reviews', [AdminController::class, 'reviews'])->name('admin.reviews');
    Route::get('admin/pendingorders', [AdminController::class, 'pendingorders'])->name('admin.pendingorders');
    Route::post('admin/pendingorders/{order}', [AdminController::class, 'update'])->name('admin.pendingorders.update');
    Route::get('admin/completedorders', [AdminController::class, 'completedorders'])->name('admin.completedorders');
    Route::get('admin/refundrequests', [AdminController::class, 'refundorders'])->name('admin.refundrequests');
    Route::get('admin/refundrequests/accept/{order}', [AdminController::class, 'acceptrefund'])->name('admin.refund.accept');
    Route::get('admin/refundrequests/reject/{order}', [AdminController::class, 'rejectrefund'])->name('admin.refund.reject');
    Route::post('/admin/notifications/mark-as-read/{id}', [NotificationController::class, 'markAsReadCus'])->name('admin.notifications.markAsRead');
    Route::get('/admin/notifications/mark-as-read', [NotificationController::class, 'markAsRead'])->name('admin.notifications.markAllAsRead');
    Route::delete('/admin/notifications/{notification}', [NotificationController::class, 'delete'])->name('admin.notifications.delete');
    Route::get('/admin/notifications/delete', [NotificationController::class, 'deleteAll'])->name('admin.notifications.deleteAll');
    Route::get('admin/notifications', [NotificationController::class, 'index'])->name('admin.notifications.index');

    Route::get('/admin/order/{order}', [AdminController::class, 'orderdetail'])->name('admin.order.show');
    // Route::get('admin/admin/templates/create', [TemplateController::class, 'create'])->name('admin.templates.create');
    Route::get('admin/templates', [EmailTemplateController::class, 'index'])->name('admin.templates.index');
    Route::get('/templates/{template}/edit', [EmailTemplateController::class, 'edit'])->name('admin.templates.create');
    Route::put('/templates/{template}', [EmailTemplateController::class, 'update'])->name('admin.templates.update');
    Route::post('admin/templates/store', [EmailTemplateController::class, 'store'])->name('admin.templates.store');
    Route::post('admin/templates/placeholders', [EmailTemplateController::class, 'addPlaceholder'])->name('admin.placeholders.add');
    Route::get('admin/payment-history', [PaymentHistoryController::class, 'index'])->name('admin.payment-history');
    Route::get('admin/charts', [ChartController::class, 'index'])->name('admin.charts.index');

    Route::get('admin/colors', [InventoryController::class, 'colorsIndex'])->name('admin.colors');
    Route::post('admin/colors/create', [InventoryController::class, 'colorCreate'])->name('admin.color.create');
    Route::get('admin/sizes', [InventoryController::class, 'sizesIndex'])->name('admin.sizes');
    Route::post('admin/sizes/create', [InventoryController::class, 'sizeCreate'])->name('admin.size.create');
    // Route::get('admin/admin/send-notification', [PushNotificationController::class, 'sendPushNotification']);
    Route::post('admin/store-token', [PushNotificationController::class, 'storeToken']);
    // Route::get('admin/admin/check-new-order', [PushNotificationController::class, 'checkNewOrder']);
});




require __DIR__ . '/auth.php';

// Route::get('admin/dashboard', [HomeController::class, 'index'])->middleware(['auth', 'verified','admin'])->name('admin.dashboard');

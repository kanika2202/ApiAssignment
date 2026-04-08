<?php

use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Front\ProductFrontController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\Front\FrontCategoryController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\CategoryFrontController;
use App\Http\Controllers\Front\CartFrontController;
use App\Http\Controllers\Front\CheckoutController;
use App\Http\Controllers\QrcodeController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\TelegramLogController;
use App\Http\Controllers\Admin\ApiController;
use App\Http\Controllers\Admin\ReportController;
use App\Models\Order;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderMail;

/*
|--------------------------------------------------------------------------
| 1. PUBLIC ROUTES (គ្រប់គ្នាអាចចូលបាន)
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class,'index'])->name('home');
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'save']);

// Register Routes
Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);

// Front-end Display
Route::get('/categories', [CategoryFrontController::class, 'index'])->name('front.categories.index');
Route::get('/category/{id}/products', [FrontCategoryController::class, 'categoryProducts'])->name('front.category.products');
Route::get('/products', [ProductController::class, 'index'])->name('front.category_products.index');
Route::get('/promotions', [ProductController::class, 'promotion'])->name('front.promotions');
Route::get('/product/{product}', [ProductFrontController::class,'show'])->name('products.show');

/*
|--------------------------------------------------------------------------
| 2. AUTH USER ROUTES (តម្រូវឱ្យ Login តែមិនចាំបាច់ជា Admin)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {
    // Cart Routes
    Route::get('/cart', [CartFrontController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [CartFrontController::class, 'add'])->name('cart.add');
    Route::patch('/cart/update/{product}', [CartFrontController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{product}', [CartFrontController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/clear', [CartFrontController::class, 'clear'])->name('cart.clear');

    // Checkout Routes
    Route::get('/checkout', [CheckoutController::class,'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class,'store'])->name('checkout.store');
    Route::get('/checkout/success/{order}', [CheckoutController::class,'success'])->name('checkout.success');

    // Logout
    Route::post('/logout', function () {
        Auth::logout();
        return redirect('/login');
    })->name('logout');
});

/*
|--------------------------------------------------------------------------
| 3. ADMIN ROUTES (តម្រូវឱ្យ Login និងមាន Role ជា Admin ទើបចូល Dashboard បាន)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])->group(function () {

    // Reports
    Route::get('/admin/reports', [ReportController::class, 'index'])->name('admin.reports');

    // Category Management
    Route::get('/category', [CategoryController::class, 'create'])->name('category.create');
    Route::post('/categoryStore', [CategoryController::class, 'store'])->name('category.store');
    Route::get('/categoryList', [CategoryController::class, 'list'])->name('category.list');
    Route::get('/categoryEdit/{id}', [CategoryController::class, 'categoryShowData'])->name('category.edit');
    Route::post('/categoryEdit', [CategoryController::class, 'categoryUpdate'])->name('category.update');
    Route::get('/categoryDelete/{id}', [CategoryController::class, 'categoryDelete']);

    // Product Management
    Route::get('/product', [ProductController::class, 'product'])->name('product.create');
    Route::post('/productStore', [ProductController::class, 'productStore'])->name('product.store');
    Route::get('/productList', [ProductController::class, 'productList'])->name('product.list');
    Route::get('/productEdit/{id}', [ProductController::class, 'productShowData'])->name('product.edit');
    Route::post('/productEdit', [ProductController::class, 'productUpdate'])->name('product.update');
    Route::get('/productDelete/{id}', [ProductController::class, 'productDelete']);

    // Banner Management
    Route::get('/banner', [BannerController::class, 'create'])->name('banner.create');
    Route::post('/bannerStore', [BannerController::class, 'store'])->name('banner.store');
    Route::get('/bannerList', [BannerController::class, 'list'])->name('banner.list');
    Route::get('/bannerEdit/{id}', [BannerController::class, 'showEdit'])->name('banner.edit');
    Route::post('/bannerEdit', [BannerController::class, 'update'])->name('banner.update');
    Route::get('/bannerDelete/{id}', [BannerController::class, 'delete'])->name('banner.delete');

    // QR Code Management
    Route::get('/qrcode', [QrcodeController::class, 'index'])->name('qrcode.index');
    Route::post('/qrcodeStore', [QrcodeController::class, 'store'])->name('qrcode.store');
    Route::get('/qrcodeDelete/{id}', [QrcodeController::class, 'delete'])->name('qrcode.delete');

    // Admin Orders Management
    Route::prefix('admin')->group(function () {
        Route::get('/orders', [OrderController::class, 'index'])->name('admin.orders.index');
        Route::get('/orders/history', [OrderController::class, 'history'])->name('admin.orders.history');
        Route::get('/orders/{id}', [OrderController::class, 'show'])->name('admin.orders.show');
        Route::get('/orders/{id}/status/{status}', [OrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');
    });

    // Admin API Control
    Route::prefix('admin/api')->group(function () {
        Route::get('/public', [ApiController::class, 'publicApi'])->name('admin.api.public');
        Route::get('/urls', [ApiController::class, 'urlList'])->name('admin.api.urls');
        Route::get('/tokens', [ApiController::class, 'tokens'])->name('admin.api.token');
        Route::post('/tokens/store', [ApiController::class, 'store'])->name('admin.api.token.store');
        Route::delete('/tokens/{id}', [ApiController::class, 'destroy'])->name('admin.api.token.destroy');
    });
});

/*
|--------------------------------------------------------------------------
| 4. OTHERS (API, Telegram & Mail)
|--------------------------------------------------------------------------
*/

// Telegram Log API Routes
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('telegram-logs', TelegramLogController::class);
});

// Test Mail Route
Route::get('/test-mail', function () {
    $order = Order::with('items')->latest()->first();
    Mail::to('kanikatouch34@gmail.com')->send(new OrderMail($order));
    return "Email Sent!";
});
// ដាក់នៅផ្នែក Public Routes
Route::get('/search', [ProductFrontController::class, 'search'])->name('front.search');
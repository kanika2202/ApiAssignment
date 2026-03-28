<?php

use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Front\ProductFrontController;
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



Route::get('/logins',[LoginController::class,'index']);
Route::post('/logins',[LoginController::class,'save']);

Route::get('/category', [CategoryController::class, 'create'])->name('category.create');

Route::post('/categoryStore', [CategoryController::class, 'store'])->name('category.store');

Route::get('/categoryList', [CategoryController::class, 'list'])->name('category.list');

Route::get('/categoryEdit/{id}', [CategoryController::class, 'categoryShowData'])->name('category.edit');
Route::post('/categoryEdit', [CategoryController::class, 'categoryUpdate'])->name('category.update');
Route::get('/categoryDelete/{id}', [CategoryController::class, 'categoryDelete']);

Route::get('/product', [ProductController::class, 'product'])->name('product.create');
Route::post('/productStore', [ProductController::class, 'productStore'])->name('product.store');
Route::get('/productList', [ProductController::class, 'productList'])->name('product.list');
Route::get('/productEdit/{id}', [ProductController::class, 'productShowData'])->name('product.edit');
Route::post('/productEdit', [ProductController::class, 'productUpdate'])->name('product.update');
Route::get('/productDelete/{id}', [ProductController::class, 'productDelete']);

use App\Http\Controllers\BannerController;

// Banner
Route::get('/banner', [BannerController::class, 'create'])->name('banner.create');
Route::post('/bannerStore', [BannerController::class, 'store'])->name('banner.store');
Route::get('/bannerList', [BannerController::class, 'list'])->name('banner.list');
Route::get('/bannerEdit/{id}', [BannerController::class, 'showEdit'])->name('banner.edit');
Route::post('/bannerEdit', [BannerController::class, 'update'])->name('banner.update');
Route::get('/bannerDelete/{id}', [BannerController::class, 'delete'])->name('banner.delete');
use App\Http\Controllers\Front\FrontCategoryController;

Route::get('/category/{id}/products', [FrontCategoryController::class, 'categoryProducts'])
      ->name('front.category.products');

use App\Http\Controllers\Front\HomeController;

Route::get('/', [HomeController::class,'index'])->name('home');
use App\Http\Controllers\Front\CategoryFrontController;

Route::get('/categories', [CategoryFrontController::class, 'index'])
    ->name('front.categories.index');


Route::get('/products', [ProductController::class, 'index'])
    ->name('front.category_products.index');
// Promotion Route (របស់អ្នក)
Route::get('/promotions', [ProductController::class, 'promotion'])->name('front.promotions');

// Cart Routes (របស់មិត្តអ្នក)
use App\Http\Controllers\Front\CartFrontController;

Route::get('/cart', [CartFrontController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{product}', [CartFrontController::class, 'add'])->name('cart.add');
Route::patch('/cart/update/{product}', [CartFrontController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{product}', [CartFrontController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [CartFrontController::class, 'clear'])->name('cart.clear');

Route::get('/product/{product}', [ProductFrontController::class,'show'])->name('products.show');

// Checkout Routes 
use App\Http\Controllers\Front\CheckoutController;

Route::get('/checkout', [CheckoutController::class,'index'])->name('checkout.index');
Route::post('/checkout', [CheckoutController::class,'store'])->name('checkout.store');
Route::get('/checkout/success/{order}', [CheckoutController::class,'success'])->name('checkout.success');

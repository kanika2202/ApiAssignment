<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductsController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\OrderApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// =============================================================
// 1. PUBLIC API (មិនប្រើ Token - ចុចទៅដើរភ្លាម)
// =============================================================

// Product APIs (Public)
Route::prefix('products')->group(function () {
    Route::get('/', [ProductsController::class, 'index']);      // http://127.0.0.1:8000/api/products
    Route::get('/{id}', [ProductsController::class, 'show']);   
});

// Category Products (Public)
Route::get('/category/{id}/products', [ProductsController::class, 'getByCategory']); 


// =============================================================
// 2. PRIVATE API (ប្រើ Middleware 'access.token' ដើម្បីការពារ)
// =============================================================



    // កន្លែងគ្រប់គ្រងផលិតផល (Admin/Private)
    Route::prefix('products')->group(function () {
        Route::post('/', [ProductsController::class, 'store']);    
        Route::put('/{product}', [ProductsController::class, 'update']);   
        Route::delete('/{product}', [ProductsController::class, 'destroy']);  
    });

    // Cart APIs (ត្រូវការ Token)
    Route::get('/cart', [CartController::class, 'index']);
    Route::get('/cart/add/{productId}', [CartController::class, 'add']);
    Route::get('/cart/remove/{id}', [CartController::class, 'remove']);
    Route::get('/cart/update/{id}', [CartController::class, 'update']);

    // Order APIs (ត្រូវការ Token)
    Route::post('/place-order', [OrderApiController::class, 'placeOrder']);
    Route::get('/orders-list', [OrderApiController::class, 'listAllOrders']);
    Route::get('/order-history', [OrderApiController::class, 'orderHistory']);
    use App\Http\Controllers\Front\CategoryFrontController;

   // Route សម្រាប់ទាញយកបញ្ជី Categories ទាំងអស់ជា JSON
Route::get('/categories', [CategoryFrontController::class, 'apiIndex']);
// routes/api.php

// សម្រាប់ Cart
Route::get('/cart-data', [App\Http\Controllers\Front\CartFrontController::class, 'apiIndex']);

// សម្រាប់ Product by Category
Route::get('/category/{id}/products', [App\Http\Controllers\Front\FrontCategoryController::class, 'categoryProducts']);
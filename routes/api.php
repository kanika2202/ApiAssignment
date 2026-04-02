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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// ប្រើ Middleware 'access.token' ដើម្បីការពារ Route ទាំងអស់ក្នុង Group នេះ
Route::middleware('access.token')->group(function () {

    // --- Product APIs ---
    Route::prefix('products')->group(function () {
        Route::get('/', [ProductsController::class, 'index']);      
        Route::post('/', [ProductsController::class, 'store']);    
        Route::get('/{id}', [ProductsController::class, 'show']);
        Route::put('/{product}', [ProductsController::class, 'update']);   
        Route::delete('/{product}', [ProductsController::class, 'destroy']);  
    });
    
    // Route សម្រាប់ទាញយកផលិតផលតាម Category
    Route::get('/category/{id}/products', [ProductsController::class, 'getByCategory']); 

    // --- Cart APIs ---
    Route::get('/cart', [CartController::class, 'index']);
Route::get('/cart/add/{productId}', [CartController::class, 'add']);
Route::get('/cart/remove/{id}', [CartController::class, 'remove']);
Route::get('/cart/update/{id}', [CartController::class, 'update']);

    Route::middleware('access.token')->group(function () {
    // សម្រាប់ Place Order
    Route::post('/place-order', [OrderApiController::class, 'placeOrder']);
   Route::get('/orders-list', [OrderApiController::class, 'listAllOrders']);
    // សម្រាប់មើលប្រវត្តិបញ្ជាទិញ (Order History)
    Route::get('/order-history', [OrderApiController::class, 'orderHistory']);
    });
});
//http://127.0.0.1:8000/api/orders-list?token=ABC123
//http://127.0.0.1:8000/api/order-history?token=ABC123
//http://127.0.0.1:8000/api/products?token=ABC123
//http://127.0.0.1:8000/api/cart/add/5?token=ABC123&qty=2
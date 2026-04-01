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

// ចាប់ផ្តើមប្រើ Middleware 'access.token' ដើម្បីការពារ Route ខាងក្រោមទាំងអស់
Route::middleware('access.token')->group(function () {

   
    Route::get('/category/{id}/products', [ProductsController::class, 'getByCategory']); 

    // --- Cart APIs ---
    Route::prefix('cart')->group(function () {
        Route::get('/', [CartController::class, 'index']);
        Route::post('/add/{productId}', [CartController::class, 'add']);
        Route::patch('/update/{id}', [CartController::class, 'update']);
        Route::delete('/remove/{id}', [CartController::class, 'remove']);
    });

    // --- Order API ---
    
    Route::post('/place-order', [OrderApiController::class, 'placeOrder']);

});
 // --- Product APIs ---
    Route::prefix('products')->group(function () {
        Route::get('/', [ProductsController::class, 'index']);      
        Route::post('/', [ProductsController::class, 'store']);    
        Route::get('/{id}', [ProductsController::class, 'show']);
        Route::put('/{product}', [ProductsController::class, 'update']);   
        Route::delete('/{product}', [ProductsController::class, 'destroy']);  
    });
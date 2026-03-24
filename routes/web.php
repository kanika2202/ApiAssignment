<?php

use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CategoryController;
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

Route::get('/logins',[LoginController::class,'index']);
Route::post('/logins',[LoginController::class,'save']);

Route::get('/category', [CategoryController::class, 'create'])->name('category.create');

Route::post('/categoryStore', [CategoryController::class, 'store'])->name('category.store');

Route::get('/categoryList', [CategoryController::class, 'list'])->name('category.list');

Route::get('/categoryEdit/{id}', [CategoryController::class, 'categoryShowData'])->name('category.edit');
Route::post('/categoryEdit', [CategoryController::class, 'categoryUpdate'])->name('category.update');
Route::get('/categoryDelete/{id}', [CategoryController::class, 'categoryDelete']);


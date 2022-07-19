<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------

*/
Route::post('register',[AuthController::class,'register'])->name('register');
Route::post('login',[AuthController::class,'login'])->name('login');
Route::get('my-profile',[AuthController::class,'myProfile'])->name('my.profile');
Route::get('all-profile',[AuthController::class,'allProfile'])->name('all.profile');

/*
|--------------------------------------------------------------------------
| Products
|--------------------------------------------------------------------------

*/

Route::post('add-product',[ProductController::class,'addProduct'])->name('add.product');
Route::get('product-list',[ProductController::class,'listOfProduct'])->name('list.product');
Route::get('product-detail/{id}',[ProductController::class,'productDetail'])->name('details.product');
Route::post('update-product/{id}',[ProductController::class,'updateProduct'])->name('update.product');
Route::delete('delete-product/{id}',[ProductController::class,'deleteProduct'])->name('delete.product');
Route::get('search/{key}',[ProductController::class,'searchProduct'])->name('search.product');

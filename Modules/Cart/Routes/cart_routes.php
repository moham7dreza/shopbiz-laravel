<?php

use Illuminate\Support\Facades\Route;
use Modules\Cart\Http\Controllers\CartController;

/*
|--------------------------------------------------------------------------
| Panel routes
|--------------------------------------------------------------------------
|
| Here you can see panel routes.
|
*/

Route::group(['prefix' => '/', 'middleware' => 'auth'], static function ($router) {
    //cart
    Route::get('/cart', [CartController::class, 'cart'])->name('customer.sales-process.cart');
    Route::post('/cart', [CartController::class, 'updateCart'])->name('customer.sales-process.update-cart');
    Route::post('/add-to-cart/{product:slug}', [CartController::class, 'addToCart'])->name('customer.sales-process.add-to-cart');
    Route::get('/remove-from-cart/{cartItem}', [CartController::class, 'removeFromCart'])->name('customer.sales-process.remove-from-cart');
});

<?php

use Illuminate\Support\Facades\Route;
use Modules\Product\Http\Controllers\GalleryController;
use Modules\Product\Http\Controllers\GuaranteeController;
use Modules\Product\Http\Controllers\ProductColorController;
use Modules\Product\Http\Controllers\StoreController;
use Modules\Product\Http\Controllers\Home\ProductController as MarketProductController;

/*
|--------------------------------------------------------------------------
| Panel routes
|--------------------------------------------------------------------------
|
| Here you can see panel routes.
|
*/

Route::group(['prefix' => 'panel/', 'middleware' => 'auth'], static function ($router) {
    $router->resource('product', 'ProductController', ['except' => 'show']);

    Route::prefix('product')->group(function () {
        //gallery
        Route::get('/gallery/{product}', [GalleryController::class, 'index'])->name('product.gallery.index');
        Route::get('/gallery/create/{product}', [GalleryController::class, 'create'])->name('product.gallery.create');
        Route::post('/gallery/store/{product}', [GalleryController::class, 'store'])->name('product.gallery.store');
        Route::delete('/gallery/destroy/{product}/{gallery}', [GalleryController::class, 'destroy'])->name('product.gallery.destroy');

        //color
        Route::get('/color/{product}', [ProductColorController::class, 'index'])->name('product.color.index');
        Route::get('/color/create/{product}', [ProductColorController::class, 'create'])->name('product.color.create');
        Route::post('/color/store/{product}', [ProductColorController::class, 'store'])->name('product.color.store');
        Route::delete('/color/destroy/{product}/{color}', [ProductColorController::class, 'destroy'])->name('product.color.destroy');

        //guarantee
        Route::get('/guarantee/{product}', [GuaranteeController::class, 'index'])->name('product.guarantee.index');
        Route::get('/guarantee/create/{product}', [GuaranteeController::class, 'create'])->name('product.guarantee.create');
        Route::post('/guarantee/store/{product}', [GuaranteeController::class, 'store'])->name('product.guarantee.store');
        Route::delete('/guarantee/destroy/{product}/{guarantee}', [GuaranteeController::class, 'destroy'])->name('product.guarantee.destroy');

        //store
        Route::prefix('store')->group(function () {
            Route::get('/', [StoreController::class, 'index'])->name('product.store.index');
            Route::get('/add-to-store/{product}', [StoreController::class, 'addToStore'])->name('product.store.add-to-store');
            Route::post('/store/{product}', [StoreController::class, 'store'])->name('product.store.store');
            Route::get('/edit/{product}', [StoreController::class, 'edit'])->name('product.store.edit');
            Route::put('/update/{product}', [StoreController::class, 'update'])->name('product.store.update');
        });

    });
});
Route::get('/product/{product:slug}', [MarketProductController::class, 'product'])->name('customer.market.product');
Route::post('/add-comment/prodcut/{product:slug}', [MarketProductController::class, 'addComment'])->name('customer.market.add-comment');
Route::get('/add-to-favorite/prodcut/{product:slug}', [MarketProductController::class, 'addToFavorite'])->name('customer.market.add-to-favorite');

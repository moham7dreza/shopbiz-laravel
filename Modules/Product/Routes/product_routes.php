<?php

use Illuminate\Support\Facades\Route;
use Modules\Product\Http\Controllers\ColorController;
use Modules\Product\Http\Controllers\GalleryController;
use Modules\Product\Http\Controllers\GuaranteeController;
use Modules\Product\Http\Controllers\ProductColorController;
use Modules\Product\Http\Controllers\ProductController;
use Modules\Product\Http\Controllers\ProductGuaranteeController;
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
    Route::get('/product/status/{product}', [ProductController::class, 'status'])->name('product.status');
    Route::get('/product/marketable/{product}', [ProductController::class, 'marketable'])->name('product.marketable');
    Route::get('/product/selected/{product}', [ProductController::class, 'selected'])->name('product.selected');

    Route::prefix('product')->group(function () {

        // tags
        Route::get('/tags-form/{product}', [ProductController::class, 'tagsForm'])->name('product.tags-from');
        Route::put('/tags-sync/{product}', [ProductController::class, 'setTags'])->name('product.tags.sync');

        // values
        Route::get('/values-form/{product}', [ProductController::class, 'valuesForm'])->name('product.values-from');

        //gallery
        Route::get('/gallery/{product}', [GalleryController::class, 'index'])->name('product.gallery.index');
        Route::get('/gallery/create/{product}', [GalleryController::class, 'create'])->name('product.gallery.create');
        Route::post('/gallery/store/{product}', [GalleryController::class, 'store'])->name('product.gallery.store');
        Route::delete('/gallery/destroy/{product}/{gallery}', [GalleryController::class, 'destroy'])->name('product.gallery.destroy');
        Route::get('/gallery/status/{gallery}', [GuaranteeController::class, 'status'])->name('product.gallery.status');

        //color
        Route::get('/color/{product}', [ProductColorController::class, 'index'])->name('product.color.index');
        Route::get('/color/create/{product}', [ProductColorController::class, 'create'])->name('product.color.create');
        Route::post('/color/store/{product}', [ProductColorController::class, 'store'])->name('product.color.store');
        Route::get('/color/edit/{product}/{color}', [ProductColorController::class, 'edit'])->name('product.color.edit');
        Route::put('/color/update/{product}/{color}', [ProductColorController::class, 'update'])->name('product.color.update');
        Route::delete('/color/destroy/{product}/{color}', [ProductColorController::class, 'destroy'])->name('product.color.destroy');
        Route::get('/color/status/{color}', [ProductColorController::class, 'status'])->name('product.color.status');

        //guarantee
        Route::get('/guarantee/{product}', [ProductGuaranteeController::class, 'index'])->name('product.guarantee.index');
        Route::get('/guarantee/create/{product}', [ProductGuaranteeController::class, 'create'])->name('product.guarantee.create');
        Route::post('/guarantee/store/{product}', [ProductGuaranteeController::class, 'store'])->name('product.guarantee.store');
        Route::get('/guarantee/edit/{product}/{guarantee}', [ProductGuaranteeController::class, 'edit'])->name('product.guarantee.edit');
        Route::put('/guarantee/update/{product}/{guarantee}', [ProductGuaranteeController::class, 'update'])->name('product.guarantee.update');
        Route::delete('/guarantee/destroy/{product}/{guarantee}', [ProductGuaranteeController::class, 'destroy'])->name('product.guarantee.destroy');
        Route::get('/guarantee/status/{guarantee}', [ProductGuaranteeController::class, 'status'])->name('product.guarantee.status');

        //store
        Route::prefix('store')->group(function () {
            Route::get('/', [StoreController::class, 'index'])->name('product.store.index');
            Route::get('/add-to-store/{product}', [StoreController::class, 'addToStore'])->name('product.store.add-to-store');
            Route::post('/store/{product}', [StoreController::class, 'store'])->name('product.store.store');
            Route::get('/edit/{product}', [StoreController::class, 'edit'])->name('product.store.edit');
            Route::put('/update/{product}', [StoreController::class, 'update'])->name('product.store.update');
        });

    });
    //color
    Route::get('/color', [ColorController::class, 'index'])->name('color.index');
    Route::get('/color/create', [ColorController::class, 'create'])->name('color.create');
    Route::post('/color/store', [ColorController::class, 'store'])->name('color.store');
    Route::get('/color/edit/{color}', [ColorController::class, 'edit'])->name('color.edit');
    Route::put('/color/update/{color}', [ColorController::class, 'update'])->name('color.update');
    Route::delete('/color/destroy/{color}', [ColorController::class, 'destroy'])->name('color.destroy');
    Route::get('/color/status/{color}', [ColorController::class, 'status'])->name('color.status');

    //guarantee
    Route::get('/guarantee', [GuaranteeController::class, 'index'])->name('guarantee.index');
    Route::get('/guarantee/create', [GuaranteeController::class, 'create'])->name('guarantee.create');
    Route::post('/guarantee/store', [GuaranteeController::class, 'store'])->name('guarantee.store');
    Route::get('/guarantee/edit/{guarantee}', [GuaranteeController::class, 'edit'])->name('guarantee.edit');
    Route::put('/guarantee/update/{guarantee}', [GuaranteeController::class, 'update'])->name('guarantee.update');
    Route::delete('/guarantee/destroy/{guarantee}', [GuaranteeController::class, 'destroy'])->name('guarantee.destroy');
    Route::get('/guarantee/status/{guarantee}', [GuaranteeController::class, 'status'])->name('guarantee.status');
});
Route::get('/product/{product:slug}', [MarketProductController::class, 'product'])->name('customer.market.product');
Route::post('/add-comment/product/{product:slug}', [MarketProductController::class, 'addComment'])->name('customer.market.add-comment');
Route::get('/add-to-favorite/product/{product:slug}', [MarketProductController::class, 'addToFavorite'])->name('customer.product.add-to-favorite');
Route::get('/like/product/{product:slug}', [MarketProductController::class, 'like'])->name('customer.product.like');
Route::get('/review/product/{product:slug}', [MarketProductController::class, 'review'])->name('customer.product.review');

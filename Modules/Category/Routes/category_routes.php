<?php

use Illuminate\Support\Facades\Route;
use Modules\Category\Http\Controllers\Home\CategoryController;
use Modules\Category\Http\Controllers\PostCategoryController;
use Modules\Category\Http\Controllers\ProductCategoryController;
use Modules\Category\Http\Controllers\PropertyController;
use Modules\Category\Http\Controllers\PropertyValueController;

/*
|--------------------------------------------------------------------------
| Panel routes
|--------------------------------------------------------------------------
|
| Here you can see panel routes.
|
*/

Route::group(['prefix' => 'panel', 'middleware' => 'auth'], static function ($router) {

    $router->resource('productCategory', 'ProductCategoryController', ['except' => 'show']);
    Route::get('productCategory/status/{productCategory}', [ProductCategoryController::class, 'status'])->name('productCategory.status');

    $router->resource('postCategory', 'PostCategoryController', ['except' => 'show']);
    Route::get('postCategory/status/{postCategory}', [PostCategoryController::class, 'status'])->name('postCategory.status');

    $router->resource('categoryAttribute', 'PropertyController', ['except' => 'show']);
    Route::get('categoryAttribute/status/{categoryAttribute}', [PropertyController::class, 'status'])->name('categoryAttribute.status');

    Route::prefix('property')->group(static function () {
        Route::get('/value/{categoryAttribute}', [PropertyValueController::class, 'index'])->name('property-value.index');
        Route::get('/value/create/{categoryAttribute}', [PropertyValueController::class, 'create'])->name('property-value.create');
        Route::post('/value/store/{categoryAttribute}', [PropertyValueController::class, 'store'])->name('property-value.store');
        Route::get('/value/edit/{categoryAttribute}/{value}', [PropertyValueController::class, 'edit'])->name('property-value.edit');
        Route::put('/value/update/{categoryAttribute}/{value}', [PropertyValueController::class, 'update'])->name('property-value.update');
        Route::delete('/value/destroy/{categoryAttribute}/{value}', [PropertyValueController::class, 'destroy'])->name('property-value.destroy');
    });
});

// products of special category
Route::get('/category/{productCategory:slug}/products', [CategoryController::class, 'categoryProducts'])->name('customer.market.category.products');
// Products selected for special sale.
Route::get('/products/special-sale', [CategoryController::class, 'bestOffers'])->name('customer.market.products.offers');
Route::get('/products/query', [CategoryController::class, 'queryProducts'])->name('customer.market.query-products');

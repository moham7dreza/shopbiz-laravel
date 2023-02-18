<?php

use Illuminate\Support\Facades\Route;
use Modules\Category\Http\Controllers\Home\CategoryController;
use Modules\Category\Http\Controllers\PostCategoryController;
use Modules\Category\Http\Controllers\ProductCategoryController;

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
    Route::get('productCategory/showInMenu/{productCategory}', [ProductCategoryController::class, 'showInMenu'])->name('productCategory.showInMenu');
    // tags
    Route::get('productCategory/tags-form/{productCategory}', [ProductCategoryController::class, 'tagsForm'])->name('productCategory.tags-from');
    Route::put('productCategory/tags-sync/{productCategory}', [ProductCategoryController::class, 'setTags'])->name('productCategory.tags.sync');

    $router->resource('postCategory', 'PostCategoryController', ['except' => 'show']);
    Route::get('postCategory/status/{postCategory}', [PostCategoryController::class, 'status'])->name('postCategory.status');
    // tags
    Route::get('postCategory/tags-form/{postCategory}', [PostCategoryController::class, 'tagsForm'])->name('postCategory.tags-from');
    Route::put('postCategory/tags-sync/{postCategory}', [PostCategoryController::class, 'setTags'])->name('postCategory.tags.sync');
});

// products of special category
Route::get('/category/{productCategory:slug}/products', [CategoryController::class, 'categoryProducts'])->name('customer.market.category.products');
// Products selected for special sale.
Route::get('/products/special-sale', [CategoryController::class, 'bestOffers'])->name('customer.market.products.offers');
Route::get('/products/query', [CategoryController::class, 'queryProducts'])->name('customer.market.query-products');

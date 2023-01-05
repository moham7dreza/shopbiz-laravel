<?php

use Illuminate\Support\Facades\Route;
use Modules\Category\Http\Controllers\ProductCategoryController;
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
    $router->resource('product-category', 'ProductCategoryController', ['except' => 'show']);
    $router->resource('post-category', 'PostCategoryController', ['except' => 'show']);
    $router->resource('category-attribute', 'PropertyController');

    Route::prefix('product-category')->group(static function () {
        Route::get('/value/{categoryAttribute}', [PropertyValueController::class, 'index'])->name('product-category.property.value.index');
        Route::get('/value/create/{categoryAttribute}', [PropertyValueController::class, 'create'])->name('product-category.property.value.create');
        Route::post('/value/store/{categoryAttribute}', [PropertyValueController::class, 'store'])->name('product-category.property.value.store');
        Route::get('/value/edit/{categoryAttribute}/{value}', [PropertyValueController::class, 'edit'])->name('product-category.property.value.edit');
        Route::put('/value/update/{categoryAttribute}/{value}', [PropertyValueController::class, 'update'])->name('product-category.property.value.update');
        Route::delete('/value/destroy/{categoryAttribute}/{value}', [PropertyValueController::class, 'destroy'])->name('product-category.property.value.destroy');
    });
});

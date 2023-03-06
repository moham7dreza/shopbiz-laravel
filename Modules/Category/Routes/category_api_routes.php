<?php


use Illuminate\Support\Facades\Route;
use Modules\Category\Http\Controllers\Api\ApiProductCategoryController;

Route::prefix('product')->group(function () {
    Route::get('categories', [ApiProductCategoryController::class, 'index'])->name('api.product.categories');
});

<?php


use Illuminate\Support\Facades\Route;
use Modules\Product\Http\Controllers\Api\ApiProductController;

Route::prefix('product')->group(function () {
    Route::get('index', [ApiProductController::class, 'index'])->name('api.product.index');
    Route::get('search', [ApiProductController::class, 'search'])->name('api.product.search');
});

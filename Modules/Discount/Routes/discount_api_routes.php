<?php


use Illuminate\Support\Facades\Route;
use Modules\Discount\Http\Api\ApiAmazingSaleController;
use Modules\Discount\Http\Api\ApiCommonDiscountController;
use Modules\Discount\Http\Api\ApiCopanDiscountController;

Route::prefix('amazing-sales')->group(function () {
    Route::get('index', [ApiAmazingSaleController::class, 'index'])->name('api.amazing-sales.index');
});
Route::prefix('common-discount')->group(function () {
    Route::get('index', [ApiCommonDiscountController::class, 'index'])->name('api.common-discount.index');
});
Route::prefix('copan-discount')->group(function () {
    Route::get('index', [ApiCopanDiscountController::class, 'index'])->name('api.copan-discount.index');
});

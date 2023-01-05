<?php

use Illuminate\Support\Facades\Route;
use Modules\Discount\Http\Controllers\DiscountController;

/*
|--------------------------------------------------------------------------
| Panel routes
|--------------------------------------------------------------------------
|
| Here you can see panel routes.
|
*/

Route::group(['prefix' => 'panel/', 'middleware' => 'auth'], static function ($router) {
//    $router->resource('discount', 'DiscountController');
    //discount
    Route::prefix('discount')->group(function () {
        Route::get('/copan', [DiscountController::class, 'copan'])->name('discount.copan');
        Route::get('/copan/create', [DiscountController::class, 'copanCreate'])->name('discount.copan.create');
        Route::get('/common-discount', [DiscountController::class, 'commonDiscount'])->name('discount.commonDiscount');
        Route::post('/common-discount/store', [DiscountController::class, 'commonDiscountStore'])->name('discount.commonDiscount.store');
        Route::get('/common-discount/edit/{commonDiscount}', [DiscountController::class, 'commonDiscountEdit'])->name('discount.commonDiscount.edit');
        Route::put('/common-discount/update/{commonDiscount}', [DiscountController::class, 'commonDiscountUpdate'])->name('discount.commonDiscount.update');
        Route::delete('/common-discount/destroy/{commonDiscount}', [DiscountController::class, 'commonDiscountDestroy'])->name('discount.commonDiscount.destroy');
        Route::get('/common-discount/create', [DiscountController::class, 'commonDiscountCreate'])->name('discount.commonDiscount.create');
        Route::get('/amazing-sale', [DiscountController::class, 'amazingSale'])->name('discount.amazingSale');
        Route::get('/amazing-sale/create', [DiscountController::class, 'amazingSaleCreate'])->name('discount.amazingSale.create');
        Route::post('/amazing-sale/store', [DiscountController::class, 'amazingSaleStore'])->name('discount.amazingSale.store');
        Route::get('/amazing-sale/edit/{amazingSale}', [DiscountController::class, 'amazingSaleEdit'])->name('discount.amazingSale.edit');
        Route::put('/amazing-sale/update/{amazingSale}', [DiscountController::class, 'amazingSaleUpdate'])->name('discount.amazingSale.update');
        Route::delete('/amazing-sale/destroy/{amazingSale}', [DiscountController::class, 'amazingSaleDestroy'])->name('discount.amazingSale.destroy');
        Route::post('/copan/store', [DiscountController::class, 'copanStore'])->name('discount.copan.store');
        Route::get('/copan/edit/{copan}', [DiscountController::class, 'copanEdit'])->name('discount.copan.edit');
        Route::put('/copan/update/{copan}', [DiscountController::class, 'copanUpdate'])->name('discount.copan.update');
        Route::delete('/copan/destroy/{copan}', [DiscountController::class, 'copanDestroy'])->name('discount.copan.destroy');
    });
});

<?php

use Illuminate\Support\Facades\Route;
use Modules\Discount\Http\Controllers\AmazingSaleController;
use Modules\Discount\Http\Controllers\CommonController;
use Modules\Discount\Http\Controllers\CopanController;

/*
|--------------------------------------------------------------------------
| Panel routes
|--------------------------------------------------------------------------
|
| Here you can see panel routes.
|
*/

Route::group(['prefix' => 'panel/discount', 'middleware' => 'auth'], static function ($router) {
    Route::resource('copanDiscount', CopanController::class)->except(['show']);
    Route::get('copanDiscount/status/{copanDiscount}', [CopanController::class, 'status'])->name('copanDiscount.status');

    Route::resource('commonDiscount', CommonController::class)->except(['show']);
    Route::get('commonDiscount/status/{commonDiscount}', [CommonController::class, 'status'])->name('commonDiscount.status');

    Route::resource('amazingSale', AmazingSaleController::class)->except(['show']);
    Route::get('amazingSale/status/{amazingSale}', [AmazingSaleController::class, 'status'])->name('amazingSale.status');
});

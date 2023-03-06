<?php


use Illuminate\Support\Facades\Route;
use Modules\Brand\Http\Controllers\Api\ApiBrandController;

Route::prefix('brand')->group(function () {
    Route::get('index', [ApiBrandController::class, 'index'])->name('api.brand.index');
});

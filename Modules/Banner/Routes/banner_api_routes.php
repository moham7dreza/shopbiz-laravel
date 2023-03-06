<?php


use Illuminate\Support\Facades\Route;
use Modules\Banner\Http\Controllers\Api\ApiBannerController;

Route::prefix('banner')->group(function () {
    Route::get('index', [ApiBannerController::class, 'index'])->name('api.banner.index');
});

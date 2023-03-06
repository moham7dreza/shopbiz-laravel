<?php


use Illuminate\Support\Facades\Route;
use Modules\Menu\Http\Controllers\Api\ApiMenuController;

Route::prefix('page')->group(function () {
    Route::get('index', [ApiMenuController::class, 'index'])->name('api.page.index');
});

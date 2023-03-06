<?php


use Illuminate\Support\Facades\Route;
use Modules\Menu\Http\Controllers\Api\ApiMenuController;

Route::prefix('menu')->group(function () {
    Route::get('index', [ApiMenuController::class, 'index'])->name('api.menu.index');
});

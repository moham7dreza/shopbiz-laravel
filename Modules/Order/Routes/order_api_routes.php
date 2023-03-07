<?php


use Illuminate\Support\Facades\Route;
use Modules\Order\Http\Controllers\Api\ApiOrderController;

Route::prefix('order')->group(function () {
    Route::get('index', [ApiOrderController::class, 'index'])->name('api.order.index');
    Route::get('new', [ApiOrderController::class, 'newOrders'])->name('api.order.new');
});

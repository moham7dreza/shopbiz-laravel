<?php


use Illuminate\Support\Facades\Route;
use Modules\Delivery\Http\Controllers\Api\ApiDeliveryController;

Route::prefix('delivery')->group(function () {
    Route::get('index', [ApiDeliveryController::class, 'index'])->name('api.delivery.index');
});

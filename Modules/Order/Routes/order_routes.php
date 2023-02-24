<?php

use Illuminate\Support\Facades\Route;
use Modules\Order\Http\Controllers\OrderController;

/*
|--------------------------------------------------------------------------
| Panel routes
|--------------------------------------------------------------------------
|
| Here you can see panel routes.
|
*/

Route::group(['prefix' => 'panel/', 'middleware' => 'auth'], static function ($router) {
//order
    Route::prefix('order')->group(function () {
        Route::get('/', [OrderController::class, 'all'])->name('order.index');
        Route::get('/new-order', [OrderController::class, 'newOrders'])->name('order.newOrders');
        Route::get('/sending', [OrderController::class, 'sending'])->name('order.sending');
        Route::get('/unpaid', [OrderController::class, 'unpaid'])->name('order.unpaid');
        Route::get('/canceled', [OrderController::class, 'canceled'])->name('order.canceled');
        Route::get('/returned', [OrderController::class, 'returned'])->name('order.returned');
        Route::get('/show/{order}', [OrderController::class, 'show'])->name('order.show');
        Route::get('/show/{order}/detail', [OrderController::class, 'detail'])->name('order.show.detail');
        Route::get('/change-send-status/{order}', [OrderController::class, 'changeSendStatus'])->name('order.changeSendStatus');
        Route::get('/change-order-status/{order}', [OrderController::class, 'changeOrderStatus'])->name('order.changeOrderStatus');
        Route::get('/cancel-order/{order}', [OrderController::class, 'cancelOrder'])->name('order.cancelOrder');
    });
});
Route::group(['prefix' => '', 'middleware' => 'auth'], static function () {
    Route::get('order-received/{order}', [\Modules\Order\Http\Controllers\Home\OrderController::class, 'index'])->name('order.received');
});

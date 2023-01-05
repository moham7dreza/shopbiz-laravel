<?php

use Illuminate\Support\Facades\Route;
use Modules\Payment\Http\Controllers\PaymentController;
use Modules\Payment\Http\Controllers\Home\PaymentController as CustomerPaymentController;

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
    //payment
    Route::prefix('payment')->group(function () {
        Route::get('/', [PaymentController::class, 'index'])->name('payment.index');
        Route::get('/online', [PaymentController::class, 'online'])->name('payment.online');
        Route::get('/offline', [PaymentController::class, 'offline'])->name('payment.offline');
        Route::get('/cash', [PaymentController::class, 'cash'])->name('payment.cash');
        Route::get('/canceled/{payment}', [PaymentController::class, 'canceled'])->name('payment.canceled');
        Route::get('/returned/{payment}', [PaymentController::class, 'returned'])->name('payment.returned');
        Route::get('/show/{payment}', [PaymentController::class, 'show'])->name('payment.show');
    });
});
Route::middleware('profile.completion')->group(function () {
    //payment
    Route::get('/payment', [CustomerPaymentController::class, 'payment'])->name('customer.sales-process.payment');
    Route::post('/copan-discount', [CustomerPaymentController::class, 'copanDiscount'])->name('customer.sales-process.copan-discount');
    Route::post('/payment-submit', [CustomerPaymentController::class, 'paymentSubmit'])->name('customer.sales-process.payment-submit');
    Route::any('/payment-callback/{order}/{onlinePayment}', [CustomerPaymentController::class, 'paymentCallback'])->name('customer.sales-process.payment-call-back');
});

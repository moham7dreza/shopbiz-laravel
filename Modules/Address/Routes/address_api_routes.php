<?php


use Illuminate\Support\Facades\Route;
use Modules\Address\Http\Controllers\Api\ApiAddressController;

Route::prefix('addresses')->group(function () {
    Route::post('/add-address', [ApiAddressController::class, 'addAddress']);
});

<?php


use Illuminate\Support\Facades\Route;
use Modules\Auth\Http\Controllers\Api\ApiLoginController;

Route::prefix('auth')->group(function () {
    Route::post('login', [ApiLoginController::class, 'login']);
});

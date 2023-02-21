<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Modules\Auth\Http\Controllers\LoginRegisterController;

/*
|--------------------------------------------------------------------------
| Panel routes
|--------------------------------------------------------------------------
|
| Here you can see panel routes.
|
*/

Route::group([], static function ($router) {
    //
    Route::group(['middleware' => ['guest']], function () {
        Route::get('login', [LoginRegisterController::class, 'loginForm'])->name('auth.login-form');
        Route::middleware('throttle:customer-login-register-limiter')
            ->post('/login', [LoginRegisterController::class, 'login'])->name('auth.login');
        Route::get('register', [LoginRegisterController::class, 'registerForm'])->name('auth.register-form');
        Route::middleware('throttle:customer-login-register-limiter')
            ->post('/register', [LoginRegisterController::class, 'register'])->name('auth.register');
    });
    //
    Route::get('login-register', [LoginRegisterController::class, 'loginRegisterForm'])->name('auth.login-register-form');
    Route::middleware('throttle:customer-login-register-limiter')->post('/login-register', [LoginRegisterController::class, 'loginRegister'])->name('auth.login-register');
    //
    Route::get('login-confirm/{token}', [LoginRegisterController::class, 'loginConfirmForm'])->name('auth.login-confirm-form');
    Route::middleware('throttle:customer-login-confirm-limiter')->post('/login-confirm/{token}', [LoginRegisterController::class, 'loginConfirm'])->name('auth.login-confirm');
    Route::middleware('throttle:customer-login-resend-otp-limiter')->get('/login-resend-otp/{token}', [LoginRegisterController::class, 'loginResendOtp'])->name('auth.login-resend-otp');
    //
    Route::group(['middleware' => ['auth']], function() {
        Route::get('/logout', [LoginRegisterController::class, 'logout'])->name('auth.logout');
    });

});

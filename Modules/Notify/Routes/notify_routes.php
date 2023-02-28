<?php

use Illuminate\Support\Facades\Route;
use Modules\Notify\Http\Controllers\EmailController;
use Modules\Notify\Http\Controllers\EmailFileController;
use Modules\Notify\Http\Controllers\NotificationController;
use Modules\Notify\Http\Controllers\SMSController;

/*
|--------------------------------------------------------------------------
| Panel routes
|--------------------------------------------------------------------------
|
| Here you can see panel routes.
|
*/

Route::group(['prefix' => 'panel/notify', 'middleware' => 'auth'], static function ($router) {
    $router->resource('email', 'EmailController', ['except' => 'show']);//email
    Route::prefix('email')->group(function () {
        Route::get('/status/{email}', [EmailController::class, 'status'])->name('email.status');
    });

    //email file
    Route::prefix('email-file')->group(function () {
        Route::get('/{email}', [EmailFileController::class, 'index'])->name('email-file.index');
        Route::get('/{email}/create', [EmailFileController::class, 'create'])->name('email-file.create');
        Route::post('/{email}/store', [EmailFileController::class, 'store'])->name('email-file.store');
        Route::get('/edit/{file}', [EmailFileController::class, 'edit'])->name('email-file.edit');
        Route::put('/update/{file}', [EmailFileController::class, 'update'])->name('email-file.update');
        Route::delete('/destroy/{file}', [EmailFileController::class, 'destroy'])->name('email-file.destroy');
        Route::get('/status/{file}', [EmailFileController::class, 'status'])->name('email-file.status');
    });

    $router->resource('sms', 'SMSController', ['except' => 'show']);
    Route::prefix('sms')->group(function () {
        Route::get('/status/{sms}', [SMSController::class, 'status'])->name('sms.status');
    });

    Route::post('/notification/read-all', [NotificationController::class, 'readAll'])->name('notification.readAll');

    Route::get('user/notifications', [NotificationController::class, 'userNotifs'])->name('user.notifications');
});

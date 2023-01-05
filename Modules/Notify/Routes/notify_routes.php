<?php

use Illuminate\Support\Facades\Route;
use Modules\Notify\Http\Controllers\EmailController;
use Modules\Notify\Http\Controllers\EmailFileController;
use Modules\Notify\Http\Controllers\NotificationController;

/*
|--------------------------------------------------------------------------
| Panel routes
|--------------------------------------------------------------------------
|
| Here you can see panel routes.
|
*/

Route::group(['prefix' => 'panel/notify', 'middleware' => 'auth'], static function ($router) {
    $router->resource('email-notify', 'EmailController', ['except' => 'show']);
    //email
    Route::prefix('email-notify')->group(function () {
        Route::get('/status/{email}', [EmailController::class, 'status'])->name('notify.email.status');
    });

    //email file
    Route::prefix('email-file')->group(function () {
        Route::get('/{email}', [EmailFileController::class, 'index'])->name('notify.email-file.index');
        Route::get('/{email}/create', [EmailFileController::class, 'create'])->name('notify.email-file.create');
        Route::post('/{email}/store', [EmailFileController::class, 'store'])->name('notify.email-file.store');
        Route::get('/edit/{file}', [EmailFileController::class, 'edit'])->name('notify.email-file.edit');
        Route::put('/update/{file}', [EmailFileController::class, 'update'])->name('notify.email-file.update');
        Route::delete('/destroy/{file}', [EmailFileController::class, 'destroy'])->name('notify.email-file.destroy');
        Route::get('/status/{file}', [EmailFileController::class, 'status'])->name('notify.email-file.status');
    });

    $router->resource('sms-notify', 'SMSController', ['except' => 'show']);

    Route::post('/notification/read-all', [NotificationController::class, 'readAll'])->name('notification.readAll');
});

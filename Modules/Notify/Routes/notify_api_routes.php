<?php


use Illuminate\Support\Facades\Route;
use Modules\Notify\Http\Controllers\Api\ApiNotificationController;

Route::prefix('notify')->group(function () {
    Route::get('notifications', [ApiNotificationController::class, 'index'])->name('api.notify.notifications.index');
});

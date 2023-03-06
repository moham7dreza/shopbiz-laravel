<?php


use Illuminate\Support\Facades\Route;
use Modules\User\Http\Controllers\Api\ApiUserController;

Route::prefix('user')->group(function () {
    Route::get('index', [ApiUserController::class, 'index'])->name('api.user.index');
});

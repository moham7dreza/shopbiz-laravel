<?php


use Illuminate\Support\Facades\Route;
use Modules\Setting\Http\Controllers\Api\ApiSettingController;

Route::prefix('setting')->group(function () {
    Route::get('index', [ApiSettingController::class, 'index'])->name('api.setting.index');
});

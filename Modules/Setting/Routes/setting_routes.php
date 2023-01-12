<?php

use Illuminate\Support\Facades\Route;
use Modules\Setting\Http\Controllers\SettingController;

/*
|--------------------------------------------------------------------------
| Panel routes
|--------------------------------------------------------------------------
|
| Here you can see panel routes.
|
*/

Route::group(['prefix' => 'panel/', 'middleware' => 'auth'], static function ($router) {
    Route::prefix('setting')->group(function () {
        Route::get('/', [SettingController::class, 'index'])->name('setting.index');
        Route::get('/edit/{setting}', [SettingController::class, 'edit'])->name('setting.edit');
        Route::put('/update/{setting}', [SettingController::class, 'update'])->name('setting.update');
        Route::delete('/destroy/{setting}', [SettingController::class, 'destroy'])->name('setting.destroy');
    });
});

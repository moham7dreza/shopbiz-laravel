<?php


use Illuminate\Support\Facades\Route;
use Modules\Faq\Http\Controllers\Api\ApiFaqController;

Route::prefix('faq')->group(function () {
    Route::get('index', [ApiFaqController::class, 'index'])->name('api.faq.index');
});

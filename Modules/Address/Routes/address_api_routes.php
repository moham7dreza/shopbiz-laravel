<?php


use Illuminate\Support\Facades\Route;
use Modules\Panel\Http\Controllers\Api\ApiPanelController;

Route::prefix('panel')->group(function () {
    Route::get('/index', [ApiPanelController::class, 'index']);
});

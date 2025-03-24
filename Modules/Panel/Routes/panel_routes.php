<?php

use Illuminate\Support\Facades\Route;
use Modules\Panel\Http\Controllers\PanelController;

/*
|--------------------------------------------------------------------------
| Panel routes
|--------------------------------------------------------------------------
|
| Here you can see panel routes.
|
*/

Route::group(['prefix' => 'panel', 'middleware' => 'auth'], static function ($router) {
    $router->get('/', ['uses' => 'PanelController', 'as' => 'panel.home']);
    Route::get('/logs', [PanelController::class, 'logs'])->name('panel.logs');
    Route::get('/sales', [PanelController::class, 'sales'])->name('panel.sales');
//    $router->get('index', [\Modules\Panel\Http\Controllers\PanelController::class, 'index'])->name('panel.home');
});

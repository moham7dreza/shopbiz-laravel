<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Panel routes
|--------------------------------------------------------------------------
|
| Here you can see panel routes.
|
*/

Route::group(['prefix' => 'panel', 'middleware' => 'auth'], static function ($router) {
    $router->get('index', ['uses' => 'PanelController', 'as' => 'panel.index']);
//    $router->get('index', [\Modules\Panel\Http\Controllers\PanelController::class, 'index'])->name('panel.index');
});

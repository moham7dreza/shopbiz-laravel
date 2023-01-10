<?php

use Illuminate\Support\Facades\Route;
use Modules\Menu\Http\Controllers\MenuController;

/*
|--------------------------------------------------------------------------
| Panel routes
|--------------------------------------------------------------------------
|
| Here you can see panel routes.
|
*/

Route::group(['prefix' => 'panel/', 'middleware' => 'auth'], static function ($router) {
    $router->resource('menu', 'MenuController', ['except' => 'show']);
    Route::get('menu/status/{menu}', [MenuController::class, 'status'])->name('menu.status');
});

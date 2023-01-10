<?php

use Illuminate\Support\Facades\Route;
use Modules\Banner\Http\Controllers\BannerController;

/*
|--------------------------------------------------------------------------
| Panel routes
|--------------------------------------------------------------------------
|
| Here you can see panel routes.
|
*/

Route::group(['prefix' => 'panel/', 'middleware' => 'auth'], static function ($router) {
    $router->resource('banner', 'BannerController', ['except' => 'show']);
    Route::get('banner/status/{banner}', [BannerController::class, 'status'])->name('banner.status');
});

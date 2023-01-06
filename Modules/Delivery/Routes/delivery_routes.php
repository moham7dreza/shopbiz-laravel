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

Route::group(['prefix' => 'panel/', 'middleware' => 'auth'], static function ($router) {
    $router->resource('delivery', 'DeliveryController', ['except' => 'show']);
    $router->get('delivery/status/{delivery}', 'DeliveryController@status')->name('delivery.status');
});

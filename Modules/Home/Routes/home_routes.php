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

Route::group(['prefix' => '/', 'middleware' => 'auth'], static function ($router) {
    $router->resource('home', 'AclController');
});

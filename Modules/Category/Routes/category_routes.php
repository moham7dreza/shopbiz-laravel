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
    $router->resource('product-category', 'ProductCategoryController');
    $router->resource('post-category', 'PostCategoryController');
    $router->resource('category-attribute', 'PropertyController');
    $router->resource('category-attribute-value', 'PropertyValueController');
});

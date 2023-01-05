<?php

use Illuminate\Support\Facades\Route;
use Modules\Post\Http\Controllers\PostController;

/*
|--------------------------------------------------------------------------
| Panel routes
|--------------------------------------------------------------------------
|
| Here you can see panel routes.
|
*/

Route::group(['prefix' => 'panel/', 'middleware' => 'auth'], static function ($router) {
    $router->resource('post', 'PostController', ['except' => 'show']);
    Route::get('post/status/{post}', [PostController::class, 'status'])->name('post.status');
    Route::get('post/commentable/{post}', [PostController::class, 'commentable'])->name('post.commentable');
});

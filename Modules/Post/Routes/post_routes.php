<?php

use Illuminate\Support\Facades\Route;
use Modules\Post\Http\Controllers\PostController;
use Modules\Post\Http\Controllers\Home\PostController as HomePostController;

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
Route::get('/post/{post:slug}', [HomePostController::class, 'post'])->name('customer.post.detail');
Route::post('/add-comment/post/{post:slug}', [HomePostController::class, 'addComment'])->name('customer.post.add-comment');
Route::get('/add-to-favorite/post/{post:slug}', [HomePostController::class, 'addToFavorite'])->name('customer.post.add-to-favorite');
Route::get('/like/post/{post:slug}', [HomePostController::class, 'like'])->name('customer.post.like');

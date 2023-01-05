<?php

use Illuminate\Support\Facades\Route;
use Modules\Comment\Http\Controllers\PostCommentController;

/*
|--------------------------------------------------------------------------
| Panel routes
|--------------------------------------------------------------------------
|
| Here you can see panel routes.
|
*/

Route::group(['prefix' => 'panel/', 'middleware' => 'auth'], static function ($router) {
    $router->resource('product-comment', 'ProductCommentController', ['except' => 'create']);
    Route::get('product-comment/approved/{comment}', 'ProductCommentController@approved')->name('product-comment.approved');
    Route::get('product-comment/status/{comment}', 'ProductCommentController@status')->name('product-comment.status');
    Route::post('product-comment/answer/{comment}', 'ProductCommentController@answer')->name('product-comment.answer');

    //comment
    Route::prefix('post-comment')->group(function () {
        Route::get('/', [PostCommentController::class, 'index'])->name('post-comment.index');
        Route::get('/show/{comment}', [PostCommentController::class, 'show'])->name('post-comment.show');
        Route::delete('/destroy/{comment}', [PostCommentController::class, 'destroy'])->name('post-comment.destroy');
        Route::get('/approved/{comment}', [PostCommentController::class, 'approved'])->name('post-comment.approved');
        Route::get('/status/{comment}', [PostCommentController::class, 'status'])->name('post-comment.status');
        Route::post('/answer/{comment}', [PostCommentController::class, 'answer'])->name('post-comment.answer');
    });
});

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
    $router->resource('productComment', 'ProductCommentController', ['except' => 'create']);
    Route::get('productComment/approved/{productComment}', 'ProductCommentController@approved')->name('productComment.approved');
    Route::get('productComment/status/{productComment}', 'ProductCommentController@status')->name('productComment.status');
    Route::post('productComment/answer/{productComment}', 'ProductCommentController@answer')->name('productComment.answer');

    //comment
    Route::prefix('postComment')->group(function () {
        Route::get('/', [PostCommentController::class, 'index'])->name('postComment.index');
        Route::get('/show/{postComment}', [PostCommentController::class, 'show'])->name('postComment.show');
        Route::delete('/destroy/{postComment}', [PostCommentController::class, 'destroy'])->name('postComment.destroy');
        Route::get('/approved/{postComment}', [PostCommentController::class, 'approved'])->name('postComment.approved');
        Route::get('/status/{postComment}', [PostCommentController::class, 'status'])->name('postComment.status');
        Route::post('/answer/{postComment}', [PostCommentController::class, 'answer'])->name('postComment.answer');
    });
});

<?php


use Illuminate\Support\Facades\Route;
use Modules\Comment\Http\Controllers\Api\ApiPostCommentController;
use Modules\Comment\Http\Controllers\Api\ApiProductCommentController;

Route::prefix('product')->group(function () {
    Route::get('comments', [ApiProductCommentController::class, 'comments'])->name('api.product.comments');
    Route::get('unseen-comments', [ApiProductCommentController::class, 'unSeenComments'])->name('api.product.unseen.comments');
    Route::get('unseen-primary-comments', [ApiProductCommentController::class, 'unseenPrimaryComments'])->name('api.product.unseen.primary.comments');
});
Route::prefix('post')->group(function () {
    Route::get('comments', [ApiPostCommentController::class, 'comments'])->name('api.post.comments');
    Route::get('unseen-comments', [ApiPostCommentController::class, 'unSeenComments'])->name('api.post.unseen.comments');
});

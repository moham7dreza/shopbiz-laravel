<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Comment\Http\Controllers\Api\ApiPostCommentController;
use Modules\Comment\Http\Controllers\Api\ApiProductCommentController;
use Modules\Notify\Http\Controllers\Api\ApiNotificationController;
use Modules\Order\Http\Controllers\Api\ApiOrderController;
use Modules\Product\Http\Controllers\Api\ApiProductController;
use Modules\Share\Http\Controllers\Api\ReportController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('report')->group(function () {
    Route::get('/weekly-sales', [ReportController::class, 'weeklyTotalSales'])->name('api.market.report.weekly.sales');
    Route::get('/monthly-sales', [ReportController::class, 'monthlyFaTotalSales'])->name('api.market.report.monthly.sales');
});

Route::prefix('product')->group(function () {
    Route::get('/index', [ApiProductController::class, 'index'])->name('api.product.index');
    Route::get('/comments', [ApiProductCommentController::class, 'comments'])->name('api.product.comments');
    Route::get('/unseen-comments', [ApiProductCommentController::class, 'unSeenComments'])->name('api.product.unseen.comments');
});
Route::prefix('post')->group(function () {
    Route::get('/comments', [ApiPostCommentController::class, 'comments'])->name('api.post.comments');
    Route::get('/unseen-comments', [ApiPostCommentController::class, 'unSeenComments'])->name('api.post.unseen.comments');
});
Route::prefix('order')->group(function () {
    Route::get('/index', [ApiOrderController::class, 'index'])->name('api.order.index');
});
Route::prefix('notify')->group(function () {
    Route::get('/notifications', [ApiNotificationController::class, 'index'])->name('api.notify.notifications.index');
});

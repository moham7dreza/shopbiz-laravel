<?php

use App\Http\Controllers\Api\ReportController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Comment\Http\Controllers\Api\ApiProductCommentController;

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

Route::prefix('product-comment')->group(function () {
    Route::get('/unSeenComments', [ApiProductCommentController::class, 'unSeenComments'])->name('api.product.unseen.comments');
});

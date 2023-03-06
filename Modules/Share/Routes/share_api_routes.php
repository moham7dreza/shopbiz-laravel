<?php


use Illuminate\Support\Facades\Route;
use Modules\Share\Http\Controllers\Api\ReportController;

Route::prefix('report')->group(function () {
    Route::get('weekly-sales', [ReportController::class, 'weeklyTotalSales'])->name('api.market.report.weekly.sales');
    Route::get('monthly-sales', [ReportController::class, 'monthlyFaTotalSales'])->name('api.market.report.monthly.sales');
});

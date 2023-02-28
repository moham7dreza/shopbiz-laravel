<?php

use Illuminate\Support\Facades\Route;
use Modules\ACL\Http\Controllers\ExcelController;
use Modules\ACL\Http\Controllers\PermissionController;
use Modules\ACL\Http\Controllers\RoleController;

/*
|--------------------------------------------------------------------------
| Panel routes
|--------------------------------------------------------------------------
|
| Here you can see panel routes.
|
*/

Route::group(['prefix' => 'panel/', 'middleware' => 'auth'], static function ($router) {
    $router->resource('role', 'RoleController', ['except' => 'show']);
    Route::get('role/status/{role}', [RoleController::class, 'status'])->name('role.status');
    Route::prefix('role')->group(function () {
        Route::get('/permission-form/{role}', [RoleController::class, 'permissionForm'])->name('role.permission-form');
        Route::put('/permission-update/{role}', [RoleController::class, 'permissionUpdate'])->name('role.permission-update');
    });

    $router->resource('permission', 'PermissionController', ['except' => 'show']);
    Route::get('permission/status/{permission}', [PermissionController::class, 'status'])->name('permission.status');

    // excel
    Route::get('/excel-form', [ExcelController::class, 'excelForm'])->name('permission.excel-form');
    Route::post('/permission-excel-import', [ExcelController::class, 'permissionExcelImport'])->name('permission.excel.import');
    Route::get('/permission-excel-export', [ExcelController::class, 'permissionExcelExport'])->name('permission.excel.export');
});

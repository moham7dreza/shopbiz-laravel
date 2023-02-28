<?php

use Illuminate\Support\Facades\Route;
use Modules\ACL\Http\Controllers\PermissionController;
use Modules\ACL\Http\Controllers\PermissionExcelController;
use Modules\ACL\Http\Controllers\RoleController;
use Modules\ACL\Http\Controllers\RoleExcelController;

/*
|--------------------------------------------------------------------------
| Panel routes
|--------------------------------------------------------------------------
|
| Here you can see panel routes.
|
*/

Route::group(['prefix' => 'panel', 'middleware' => 'auth'], static function ($router) {
    // role
    $router->resource('role', 'RoleController', ['except' => 'show']);
    Route::group(['prefix' => 'role'], static function () {
        Route::get('status/{role}', [RoleController::class, 'status'])->name('role.status');
        // role permissions
        Route::get('/permission-form/{role}', [RoleController::class, 'permissionForm'])->name('role.permission-form');
        Route::put('/permission-update/{role}', [RoleController::class, 'permissionUpdate'])->name('role.permission-update');
        // excel
        Route::get('excel-form', [RoleExcelController::class, 'excelForm'])->name('role.excel-form');
        Route::post('excel-import', [RoleExcelController::class, 'roleExcelImport'])->name('role.excel.import');
        Route::get('excel-export', [RoleExcelController::class, 'roleExcelExport'])->name('role.excel.export');
    });

    // permission
    $router->resource('permission', 'PermissionController', ['except' => 'show']);
    Route::prefix('permission')->group(function () {
        Route::get('status/{permission}', [PermissionController::class, 'status'])->name('permission.status');
        // excel
        Route::get('excel-form', [PermissionExcelController::class, 'excelForm'])->name('permission.excel-form');
        Route::post('excel-import', [PermissionExcelController::class, 'permissionExcelImport'])->name('permission.excel.import');
        Route::get('excel-export', [PermissionExcelController::class, 'permissionExcelExport'])->name('permission.excel.export');
    });
});

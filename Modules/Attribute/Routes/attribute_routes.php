<?php


use Illuminate\Support\Facades\Route;
use Modules\Attribute\Http\Controllers\PropertyController;
use Modules\Attribute\Http\Controllers\PropertyValueController;

Route::group(['prefix' => 'panel', 'middleware' => 'auth'], static function ($router) {

    $router->resource('categoryAttribute', 'PropertyController', ['except' => 'show']);
    Route::get('categoryAttribute/status/{categoryAttribute}', [PropertyController::class, 'status'])->name('categoryAttribute.status');

    Route::prefix('property')->group(static function () {
        Route::get('/value/{categoryAttribute}', [PropertyValueController::class, 'index'])->name('CategoryValue.index');
        Route::get('/value/create/{categoryAttribute}', [PropertyValueController::class, 'create'])->name('CategoryValue.create');
        Route::post('/value/store/{categoryAttribute}', [PropertyValueController::class, 'store'])->name('CategoryValue.store');
        Route::get('/value/edit/{categoryAttribute}/{value}', [PropertyValueController::class, 'edit'])->name('CategoryValue.edit');
        Route::put('/value/update/{categoryAttribute}/{value}', [PropertyValueController::class, 'update'])->name('CategoryValue.update');
        Route::delete('/value/destroy/{categoryAttribute}/{value}', [PropertyValueController::class, 'destroy'])->name('CategoryValue.destroy');
    });
});

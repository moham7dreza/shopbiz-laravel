<?php


use Illuminate\Support\Facades\Route;
use Modules\Attribute\Http\Controllers\AttributeController;
use Modules\Attribute\Http\Controllers\AttributeValueController;

Route::group(['prefix' => 'panel', 'middleware' => 'auth'], static function ($router) {

    $router->resource('attribute', 'AttributeController', ['except' => 'show']);
    Route::get('attribute/status/{attribute}', [AttributeController::class, 'status'])->name('attribute.status');
    Route::prefix('attribute')->group(function () {
        Route::get('/category-form/{attribute}', [AttributeController::class, 'categoryForm'])->name('attribute.category-form');
        Route::put('/category-update/{attribute}', [AttributeController::class, 'categoryUpdate'])->name('attribute.category-update');
    });

//    Route::resource('attributeValue/{attribute}', AttributeValueController::class)->except('show');
    Route::prefix('attributeValue')->group(static function () {
        Route::get('/{attribute}', [AttributeValueController::class, 'index'])->name('attributeValue.index');
        Route::get('/create/{attribute}', [AttributeValueController::class, 'create'])->name('attributeValue.create');
        Route::post('/store/{attribute}', [AttributeValueController::class, 'store'])->name('attributeValue.store');
        Route::get('/edit/{attribute}/{value}', [AttributeValueController::class, 'edit'])->name('attributeValue.edit');
        Route::put('/update/{attribute}/{value}', [AttributeValueController::class, 'update'])->name('attributeValue.update');
        Route::delete('/destroy/{attribute}/{value}', [AttributeValueController::class, 'destroy'])->name('attributeValue.destroy');
    });
});

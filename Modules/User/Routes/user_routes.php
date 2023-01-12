<?php

use Illuminate\Support\Facades\Route;
use Modules\User\Http\Controllers\AdminUserController;
use Modules\User\Http\Controllers\CustomerController;
use Modules\User\Http\Controllers\Home\Profile\AddressController;
use Modules\User\Http\Controllers\Home\Profile\FavoriteController;
use Modules\User\Http\Controllers\Home\Profile\OrderController;
use Modules\User\Http\Controllers\Home\Profile\ProfileController;

/*
|--------------------------------------------------------------------------
| Panel routes
|--------------------------------------------------------------------------
|
| Here you can see panel routes.
|
*/

Route::group(['prefix' => 'panel', 'middleware' => 'auth'], static function ($router) {
    $router->resource('adminUser', 'AdminUserController', ['except' => 'show']);
    //admin-user
    Route::prefix('adminUser')->group(function () {
        Route::get('/status/{user}', [AdminUserController::class, 'status'])->name('adminUser.status');
        Route::get('/activation/{user}', [AdminUserController::class, 'activation'])->name('adminUser.activation');
        Route::get('/roles/{admin}', [AdminUserController::class, 'roles'])->name('adminUser.roles');
        Route::post('/roles/{admin}/store', [AdminUserController::class, 'rolesStore'])->name('adminUser.roles.store');
        Route::get('/permissions/{admin}', [AdminUserController::class, 'permissions'])->name('adminUser.permissions');
        Route::post('/permissions/{admin}/store', [AdminUserController::class, 'permissionsStore'])->name('adminUser.permissions.store');
    });

    $router->resource('customerUser', 'CustomerController', ['except' => 'show']);
    //customer
    Route::prefix('customerUser')->group(function () {
        Route::get('/status/{user}', [CustomerController::class, 'status'])->name('customerUser.status');
        Route::get('/activation/{user}', [CustomerController::class, 'activation'])->name('customerUser.activation');
    });
});
Route::get('/orders', [OrderController::class, 'index'])->name('customer.profile.orders');
Route::get('/my-favorites', [FavoriteController::class, 'index'])->name('customer.profile.my-favorites');
Route::get('/my-favorites/delete/{product}', [FavoriteController::class, 'delete'])->name('customer.profile.my-favorites.delete');
Route::get('/profile', [ProfileController::class, 'index'])->name('customer.profile.profile');
Route::put('/profile/update', [ProfileController::class, 'update'])->name('customer.profile.profile.update');
Route::get('/my-addresses', [AddressController::class, 'index'])->name('customer.profile.my-addresses');

<?php

use Illuminate\Support\Facades\Route;
use Modules\Home\Http\Controllers\HomeController;
use Modules\Home\Http\Controllers\SalesProcess\ProfileCompletionController;

/*
|--------------------------------------------------------------------------
| Panel routes
|--------------------------------------------------------------------------
|
| Here you can see panel routes.
|
*/

Route::group(['prefix' => '/', 'middleware' => 'auth'], static function ($router) {
    Route::get('/', [HomeController::class, 'home'])->name('customer.home');

    //profile completion
    Route::get('/profile-completion', [ProfileCompletionController::class, 'profileCompletion'])->name('customer.sales-process.profile-completion');
    Route::post('/profile-completion', [ProfileCompletionController::class, 'update'])->name('customer.sales-process.profile-completion-update');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

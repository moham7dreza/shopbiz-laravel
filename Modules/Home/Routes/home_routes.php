<?php

use Illuminate\Support\Facades\Route;
use Modules\Home\Http\Controllers\HomeController;
use Modules\Home\Http\Controllers\SalesProcess\AddressController;
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
Route::middleware('profile.completion')->group(function () {
    //address
    Route::get('/address-and-delivery', [AddressController::class, 'addressAndDelivery'])->name('customer.sales-process.address-and-delivery');
    Route::post('/add-address', [AddressController::class, 'addAddress'])->name('customer.sales-process.add-address');
    Route::put('/update-address/{address}', [AddressController::class, 'updateAddress'])->name('customer.sales-process.update-address');
    Route::get('/get-cities/{province}', [AddressController::class, 'getCities'])->name('customer.sales-process.get-cities');
    Route::post('/choose-address-and-delivery', [AddressController::class, 'chooseAddressAndDelivery'])->name('customer.sales-process.choose-address-and-delivery');

});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

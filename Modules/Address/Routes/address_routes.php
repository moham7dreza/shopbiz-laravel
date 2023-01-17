<?php

/*
|--------------------------------------------------------------------------
| address routes
|--------------------------------------------------------------------------
|
| Here you can see address routes.
|
*/

use Illuminate\Support\Facades\Route;
use Modules\Address\Http\Controllers\Home\AddressController;

Route::middleware('profile.completion')->group(function () {
    //address
    Route::get('/address-and-delivery', [AddressController::class, 'addressAndDelivery'])->name('customer.sales-process.address-and-delivery');
    Route::post('/add-address', [AddressController::class, 'addAddress'])->name('customer.sales-process.add-address');
    Route::put('/update-address/{address}', [AddressController::class, 'updateAddress'])->name('customer.sales-process.update-address');
    Route::get('/get-cities/{province}', [AddressController::class, 'getCities'])->name('customer.sales-process.get-cities');
    Route::post('/choose-address-and-delivery', [AddressController::class, 'chooseAddressAndDelivery'])->name('customer.sales-process.choose-address-and-delivery');

});

<?php

use Illuminate\Support\Facades\Route;
use Modules\Contact\Http\Controllers\Home\HomeContactController;

Route::prefix('pages')->group(function () {
    Route::get('/contact-us', [HomeContactController::class, 'contactUs'])->name('customer.pages.contact-us');
    Route::post('/contact-us', [HomeContactController::class, 'contactUsSubmit'])->name('customer.pages.contact-us.submit');

    Route::get('/make-appointment', [HomeContactController::class, 'makeAppointment'])->name('customer.pages.make-appointment');
    Route::post('/make-appointment', [HomeContactController::class, 'meetSubmit'])->name('customer.pages.make-appointment.submit');
});

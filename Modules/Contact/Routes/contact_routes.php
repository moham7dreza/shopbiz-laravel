<?php

use Illuminate\Support\Facades\Route;
use Modules\Contact\Http\Controllers\AppointmentController;
use Modules\Contact\Http\Controllers\ContactController;
use Modules\Contact\Http\Controllers\Home\HomeContactController;

Route::prefix('pages')->group(function () {
    Route::get('/contact-us', [HomeContactController::class, 'contactUs'])->name('customer.pages.contact-us');
    Route::post('/contact-us', [HomeContactController::class, 'contactUsSubmit'])->name('customer.pages.contact-us.submit');

    Route::get('/make-appointment', [HomeContactController::class, 'makeAppointment'])->name('customer.pages.make-appointment');
    Route::post('/make-appointment', [HomeContactController::class, 'meetSubmit'])->name('customer.pages.make-appointment.submit');
});

Route::group(['prefix' => 'panel/', 'middleware' => 'auth'], static function () {

    Route::prefix('contact')->group(function () {
        //main
        Route::get('/', [ContactController::class, 'index'])->name('contact.index');
        Route::get('/show/{contact}', [ContactController::class, 'show'])->name('contact.show');
        Route::post('/answer/{contact}', [ContactController::class, 'answer'])->name('contact.answer');
        Route::get('/approved/{contact}', [ContactController::class, 'approved'])->name('contact.approved');
        Route::get('/status/{contact}', [ContactController::class, 'status'])->name('contact.status');
    });

    Route::prefix('appointment')->group(function () {
        //main
        Route::get('/', [AppointmentController::class, 'index'])->name('appointment.index');
        Route::get('/show/{appointment}', [AppointmentController::class, 'show'])->name('appointment.show');
        Route::post('/answer/{appointment}', [AppointmentController::class, 'answer'])->name('appointment.answer');
        Route::get('/change/{appointment}', [AppointmentController::class, 'change'])->name('appointment.change');
        Route::get('/approved/{appointment}', [AppointmentController::class, 'approved'])->name('appointment.approved');
        Route::get('/status/{appointment}', [AppointmentController::class, 'status'])->name('appointment.status');
    });
});

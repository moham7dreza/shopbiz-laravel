<?php

use Illuminate\Support\Facades\Route;
use Modules\Home\Http\Controllers\HomeController;
use Modules\Home\Http\Controllers\PageController;
use Modules\Home\Http\Controllers\SalesProcess\ProfileCompletionController;

/*
|--------------------------------------------------------------------------
| Panel routes
|--------------------------------------------------------------------------
|
| Here you can see panel routes.
|
*/
Route::get('/', [HomeController::class, 'home'])->name('customer.home');

Route::group(['prefix' => '/', 'middleware' => 'auth'], static function ($router) {
    //profile completion
    Route::get('/profile-completion', [ProfileCompletionController::class, 'profileCompletion'])->name('customer.sales-process.profile-completion');
    Route::post('/profile-completion', [ProfileCompletionController::class, 'update'])->name('customer.sales-process.profile-completion-update');
});

Route::prefix('pages')->group(function () {
    Route::get('/about-us', [PageController::class, 'aboutUs'])->name('customer.pages.about-us');
    Route::get('/privacy-policy', [PageController::class, 'privacyPolicy'])->name('customer.pages.privacy-policy');
    Route::get('/warranty-rules', [PageController::class, 'warrantyRules'])->name('customer.pages.warranty-rules');
    Route::get('/faq', [PageController::class, 'faq'])->name('customer.pages.faq');
    Route::get('/career', [PageController::class, 'career'])->name('customer.pages.career');
    Route::get('/price-plans', [PageController::class, 'price'])->name('customer.pages.price');
    Route::get('/installment', [PageController::class, 'installment'])->name('customer.pages.installment');
    Route::get('/why-this-shop', [PageController::class, 'whyThisShop'])->name('customer.pages.why-this-shop');
    Route::get('/how-to-buy', [PageController::class, 'howToBuy'])->name('customer.pages.how-to-buy');
});

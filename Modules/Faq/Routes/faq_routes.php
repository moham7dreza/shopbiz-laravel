<?php

use Illuminate\Support\Facades\Route;
use Modules\Faq\Http\Controllers\FaqController;

/*
|--------------------------------------------------------------------------
| Panel routes
|--------------------------------------------------------------------------
|
| Here you can see panel routes.
|
*/

Route::group(['prefix' => 'panel/', 'middleware' => 'auth'], static function ($router) {
    $router->resource('faq', 'FaqController', ['except' => 'show']);
    Route::get('faq/status/{faq}', [FaqController::class, 'status'])->name('faq.status');
    // tags
    Route::get('faq/tags-form/{faq}', [FaqController::class, 'tagsForm'])->name('faq.tags-from');
    Route::put('faq/tags-sync/{faq}', [FaqController::class, 'setTags'])->name('faq.tags.sync');
});

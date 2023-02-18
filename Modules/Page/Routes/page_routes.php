<?php

use Illuminate\Support\Facades\Route;
use Modules\Page\Http\Controllers\PageController;

/*
|--------------------------------------------------------------------------
| Panel routes
|--------------------------------------------------------------------------
|
| Here you can see panel routes.
|
*/

Route::group(['prefix' => 'panel/', 'middleware' => 'auth'], static function ($router) {
    $router->resource('page', 'PageController', ['except' => 'show']);
    Route::get('page/status/{page}', [PageController::class, 'status'])->name('page.status');
    // tags
    Route::get('page/tags-form/{page}', [PageController::class, 'tagsForm'])->name('page.tags-from');
    Route::put('page/tags-sync/{page}', [PageController::class, 'setTags'])->name('page.tags.sync');
});

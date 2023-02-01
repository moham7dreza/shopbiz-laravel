<?php
/*
|--------------------------------------------------------------------------
| Panel routes
|--------------------------------------------------------------------------
|
| Here you can see panel routes.
|
*/

use Illuminate\Support\Facades\Route;
use Modules\Tag\Http\Controllers\TagController;

Route::group(['prefix' => 'panel/', 'middleware' => 'auth'], static function () {
    Route::resource('tag', TagController::class)->except(['show']);
    Route::get('tag/status/{tag}', [TagController::class, 'status'])->name('tag.status');
});

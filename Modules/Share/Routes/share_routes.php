<?php

use Illuminate\Support\Facades\Route;
use Modules\Share\Http\Controllers\CaptchaController;

Route::get('captcha', [CaptchaController::class, 'index'])->name('captcha');

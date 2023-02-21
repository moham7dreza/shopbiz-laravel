<?php

namespace Modules\Auth\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Modules\Auth\Http\Requests\LoginRegisterRequest;
use Modules\Auth\Http\Requests\LoginRequest;
use Modules\Share\Http\Controllers\Controller;
use Modules\Share\Traits\ShowMessageWithRedirectTrait;

class LoginController extends Controller
{
    use ShowMessageWithRedirectTrait;

    /**
     * @return Application|Factory|View
     */
    public function index(): Factory|View|Application
    {
        return view('Auth::login');
    }

    /**
     * @param LoginRequest $request
     * @return RedirectResponse
     */
    public function login(LoginRequest $request): RedirectResponse
    {
        $credentials = $request->only('email', 'password');
        if (!Auth::validate($credentials)) {
            return $this->showAlertWithRedirect(message:'ایمیل و رمز عبور با یکدیگر مطابقت ندارند.', title: 'خطا', type: 'error', route: 'auth.login-form');
        }
        $user = Auth::getProvider()->retrieveByCredentials($credentials);
        Auth::login($user);
        return $this->showAlertWithRedirect('با موفقیت وارد شدید', route: 'customer.home');
    }
}

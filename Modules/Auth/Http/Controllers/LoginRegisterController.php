<?php

namespace Modules\Auth\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Modules\Auth\Http\Requests\LoginRegisterRequest;
use Modules\Auth\Repositories\AuthRepoEloquentInterface;
use Modules\Auth\Services\AuthService;
use Modules\Share\Http\Controllers\Controller;
use Modules\Share\Traits\ShowMessageWithRedirectTrait;
use Modules\User\Repositories\UserRepoEloquentInterface;

class LoginRegisterController extends Controller
{
    use ShowMessageWithRedirectTrait;

    public AuthRepoEloquentInterface $repo;
    private AuthService $service;

    /**
     * @param AuthRepoEloquentInterface $authRepoEloquent
     * @param AuthService $authService
     */
    public function __construct(AuthRepoEloquentInterface $authRepoEloquent, AuthService $authService)
    {
        $this->repo = $authRepoEloquent;
        $this->service = $authService;
    }

    /**
     * @return Application|Factory|View
     */
    public function loginRegisterForm(): Factory|View|Application
    {
        return view('Auth::home.login-register');
    }

    /**
     * @return Application|Factory|View
     */
    public function loginForm(): Factory|View|Application
    {
        return view('Auth::home.login');
    }

    /**
     * @param LoginRegisterRequest $request
     * @param UserRepoEloquentInterface $userRepo
     * @return RedirectResponse
     */
    public function loginRegister(LoginRegisterRequest $request, UserRepoEloquentInterface $userRepo): RedirectResponse
    {
        $token = $this->service->loginRegister($request->id, $userRepo);
        if ($token === 'id invalid') {
            return $this->showAlertWithRedirect(message:'شناسه ورودی شما نه شماره موبایل است نه ایمیل', title: 'خطا', type: 'error', route: 'auth.login-register-form');
        }
        return to_route('auth.login-confirm-form', $token);
    }

    /**
     * @param LoginRegisterRequest $request
     * @return RedirectResponse
     */
    public function login(LoginRegisterRequest $request): RedirectResponse
    {
        $credentials = $request->only('email', 'password');
        if (!Auth::validate($credentials)) {
            return $this->showAlertWithRedirect(message:'ایمیل و رمز عبور با یکدیگر مطابقت ندارند.', title: 'خطا', type: 'error', route: 'auth.login-form');
        }
        $user = Auth::getProvider()->retrieveByCredentials($credentials);
        Auth::login($user);
        return $this->showAlertWithRedirect('با موفقیت وارد شدید', route: 'customer.home');
    }


    /**
     * @param $token
     * @return Application|Factory|View|RedirectResponse
     */
    public function loginConfirmForm($token): View|Factory|RedirectResponse|Application
    {
        $otp = $this->repo->findByToken($token);
        if (empty($otp)) {
            return $this->showAlertWithRedirect(message: 'آدرس وارد شده نامعتبر میباشد', title: 'خطا', type: 'error', route: 'auth.login-register-form');
//            return to_route('auth.login-register-form')->withErrors(['id' => 'آدرس وارد شده نامعتبر میباشد']);
        }
        return view('Auth::home.login-confirm', compact(['token', 'otp']));
    }


    /**
     * @param $token
     * @param LoginRegisterRequest $request
     * @return RedirectResponse
     */
    public function loginConfirm($token, LoginRegisterRequest $request): RedirectResponse
    {
        $otp = $this->repo->findValidOtp($token);
        if (empty($otp)) {
            return $this->showAlertWithRedirect(message: 'آدرس وارد شده نامعتبر میباشد', title: 'خطا', type: 'error', route: 'auth.login-register-form');
//            return to_route('auth.login-register-form', $token)->withErrors(['id' => 'آدرس وارد شده نامعتبر میباشد']);
        }
        //if otp not match
        if ($otp->otp_code !== $request->otp) {
            return $this->showAlertWithRedirect(message: 'کد وارد شده صحیح نمیباشد', title: 'خطا', type: 'error', route: 'auth.login-register-form');
//            return to_route('auth.login-confirm-form', $token)->withErrors(['otp' => 'کد وارد شده صحیح نمیباشد']);
        }
        $this->service->updateAndLoginUser($otp);
        return $this->showToastWithRedirect(title: 'شما با موفقیت وارد حساب کاربری خود شدید', route: 'customer.home');
//        return to_route('customer.home');
    }


    /**
     * @param $token
     * @return RedirectResponse
     */
    public function loginResendOtp($token): RedirectResponse
    {
        $otp = $this->repo->findExpiredOtp($token);

        if (empty($otp)) {
            return $this->showAlertWithRedirect(message: 'آدرس وارد شده نامعتبر میباشد', title: 'خطا', type: 'error', route: 'auth.login-register-form');
//            return to_route('auth.login-register-form', $token)->withErrors(['id' => 'ادرس وارد شده نامعتبر است']);
        }
        $token = $this->service->resendOtp($otp);
        return to_route('auth.login-confirm-form', $token);

    }

    /**
     * @return RedirectResponse
     */
    public function logout(): RedirectResponse
    {
        Session::flush();
        Auth::logout();
        return $this->showToastWithRedirect(title: 'شما از حساب کاربری خود خارج شدید', route: 'customer.home');
//        return to_route('customer.home');
    }
}

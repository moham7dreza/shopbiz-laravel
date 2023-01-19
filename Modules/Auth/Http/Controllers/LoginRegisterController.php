<?php

namespace Modules\Auth\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Modules\Auth\Http\Requests\LoginRegisterRequest;
use Modules\Auth\Repositories\AuthRepoEloquentInterface;
use Modules\Auth\Services\AuthService;
use Modules\Share\Http\Controllers\Controller;
use Modules\User\Repositories\UserRepoEloquentInterface;

class LoginRegisterController extends Controller
{
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
     * @param LoginRegisterRequest $request
     * @param UserRepoEloquentInterface $userRepo
     * @return RedirectResponse
     */
    public function loginRegister(LoginRegisterRequest $request, UserRepoEloquentInterface $userRepo): RedirectResponse
    {
        $token = $this->service->loginRegister($request->id, $userRepo);
        return to_route('auth.login-confirm-form', $token);
    }


    /**
     * @param $token
     * @return Application|Factory|View|RedirectResponse
     */
    public function loginConfirmForm($token): View|Factory|RedirectResponse|Application
    {
        $otp = $this->repo->findByToken($token);
        if (empty($otp)) {
            return to_route('auth.login-register-form')->withErrors(['id' => 'آدرس وارد شده نامعتبر میباشد']);
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
            return to_route('auth.login-register-form', $token)->withErrors(['id' => 'آدرس وارد شده نامعتبر میباشد']);
        }
        //if otp not match
        if ($otp->otp_code !== $request->otp) {
            return to_route('auth.login-confirm-form', $token)->withErrors(['otp' => 'کد وارد شده صحیح نمیباشد']);
        }
        $this->service->updateAndLoginUser($otp);
        return to_route('customer.home');
    }


    /**
     * @param $token
     * @return RedirectResponse
     */
    public function loginResendOtp($token): RedirectResponse
    {
        $otp = $this->repo->findExpiredOtp($token);

        if (empty($otp)) {
            return to_route('auth.login-register-form', $token)->withErrors(['id' => 'ادرس وارد شده نامعتبر است']);
        }
        $token = $this->service->resendOtp($otp);
        return to_route('auth.login-confirm-form', $token);

    }

    /**
     * @return RedirectResponse
     */
    public function logout(): RedirectResponse
    {
        Auth::logout();
        return to_route('customer.home');
    }
}

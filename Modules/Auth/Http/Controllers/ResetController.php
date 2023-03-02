<?php

namespace Modules\Auth\Http\Controllers;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\NoReturn;
use Modules\Auth\Http\Requests\ResetRequest;
use Modules\Share\Http\Controllers\Controller;
use Modules\Share\Traits\ShowMessageWithRedirectTrait;

class ResetController extends Controller
{
    use ShowMessageWithRedirectTrait;

    /**
     * @return Application|Factory|View
     */
    public function resetPasswordForm(): View|Factory|Application
    {
        return view('Auth::reset.reset-form');
    }

    /**
     * @param ResetRequest $request
     * @return RedirectResponse
     */
    public function resetPassword(ResetRequest $request): RedirectResponse
    {
        $reset = Password::sendResetLink($request->only('email'));

        return $reset === Password::RESET_LINK_SENT ?
            $this->showAlertWithRedirect('لینک بازیابی با موفقیت به ایمیل شما ارسال شد') :
            $this->showAlertWithRedirect(message:'مشکلی در سیستم به وجود امده لطفا دوباره تلاش کنید', title: 'خطا', type: 'error');
    }

    /**
     * @param Request $request
     * @return Application|Factory|View
     */
    public function verifyPasswordForm(Request $request): View|Factory|Application
    {
        $token = $request->token;
        $email = $request->email;

        return view('Auth::reset.verify-form', compact(['token', 'email']));
    }

    /**
     * @param ResetRequest $request
     * @return RedirectResponse
     */
    public function verifyPassword(ResetRequest $request): RedirectResponse
    {
        $reset = Password::reset(
            $request->only('token', 'email', 'password', 'password_confirmation'),
            static function ($user, $password) use ($request) {
                $user->forceFill(['password' => bcrypt($password)])->setRememberToken(Str::random(60));

                $user->save();

                event(new ResetPassword($request->token));
            }
        );

        return $reset === Password::PASSWORD_RESET ?
            $this->showAlertWithRedirect('رمز عبور شما با موفقیت تغییر کرد.', route: 'auth.login-form') :
            $this->showAlertWithRedirect(message:'مشکلی در سیستم به وجود امده لطفا دوباره تلاش کنید', title: 'خطا', type: 'error');
    }
}

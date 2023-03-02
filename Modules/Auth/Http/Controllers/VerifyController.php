<?php

namespace Modules\Auth\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\Share\Http\Controllers\Controller;
use Modules\Share\Traits\ShowMessageWithRedirectTrait;

class VerifyController extends Controller
{
    use ShowMessageWithRedirectTrait;

    /**
     * @return Application|Factory|View
     */
    public function index(): View|Factory|Application
    {
        return view('Auth::verify.index');
    }

    /**
     * @param EmailVerificationRequest $request
     * @return RedirectResponse
     */
    public function verify(EmailVerificationRequest $request): RedirectResponse
    {
        $request->fulfill();
        return $this->showAlertWithRedirect('ایمیل شما با موفقیت تایید شد.', route: 'customer.home');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function resend(Request $request): RedirectResponse
    {
        $request->user()->sendEmailVerificationNotification();
        return $this->showAlertWithRedirect('لینک تایید به ایمیل شما ارسال شد.')
            ->with(['message' => 'اگر ایمیل خود را تایید کرده اید میتوانید این صفحه را ببندید.']);
    }
}

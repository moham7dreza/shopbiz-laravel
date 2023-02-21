<?php

namespace Modules\Auth\Http\Controllers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Modules\Auth\Http\Requests\LoginRegisterRequest;
use Modules\Auth\Http\Requests\RegisterRequest;
use Modules\Share\Http\Controllers\Controller;
use Modules\Share\Traits\ShowMessageWithRedirectTrait;
use Modules\User\Entities\User;

class RegisterController extends Controller
{
    use ShowMessageWithRedirectTrait;

    /**
     * @return Application|Factory|View
     */
    public function index(): Factory|View|Application
    {
        return view('Auth::register');
    }

    /**
     * @param RegisterRequest $request
     * @return RedirectResponse
     */
    public function register(RegisterRequest $request): RedirectResponse
    {
        $user = User::query()->create($request->validated());

        auth()->loginUsingId($user->id);

        event(new Registered($user));

        return $this->showAlertWithRedirect('حساب شما با موفقیت ایجاد شد.', route: 'customer.home');
    }
}

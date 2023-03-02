<?php

namespace Modules\Auth\Http\Controllers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Modules\Auth\Http\Requests\LoginRegisterRequest;
use Modules\Auth\Http\Requests\RegisterRequest;
use Modules\Share\Http\Controllers\Controller;
use Modules\Share\Services\ShareService;
use Modules\Share\Traits\ShowMessageWithRedirectTrait;
use Modules\User\Entities\User;
use Modules\User\Services\UserService;

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
     * @param UserService $userService
     * @return RedirectResponse
     */
    public function register(RegisterRequest $request, UserService $userService): RedirectResponse
    {
        $user = $userService->store($request);

        auth()->loginUsingId($user->id);

        event(new Registered($user));

        return $this->showAlertWithRedirect('حساب شما با موفقیت ایجاد شد.', route: 'auth.verify.email');
    }
}

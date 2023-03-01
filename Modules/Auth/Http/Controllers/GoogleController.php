<?php

namespace Modules\Auth\Http\Controllers;

use Illuminate\Http\Client\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Modules\Share\Http\Controllers\Controller;
use Modules\Share\Traits\ShowMessageWithRedirectTrait;
use Modules\User\Entities\User;
use Modules\User\Repositories\UserRepoEloquentInterface;
use Modules\User\Services\UserService;

class GoogleController extends Controller
{
    use ShowMessageWithRedirectTrait;

    /**
     * @return RedirectResponse|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirect(): \Symfony\Component\HttpFoundation\RedirectResponse|RedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * @param Request $request
     * @param UserRepoEloquentInterface $userRepo
     * @param UserService $userService
     * @return RedirectResponse
     */
    public function callback(Request $request, UserRepoEloquentInterface $userRepo, UserService $userService): RedirectResponse
    {
        try {
            $google = Socialite::driver('google')->user();
            $user = $userRepo->findByEmail($google->email);

            if (! $user) {
                // Create User
                $user = User::query()->create([
                    'name' => $google->name,
                    'email' => $google->email,
                    'password' => bcrypt(Str::random()),
                ]);
            }

            auth()->loginUsingId($user->id);

            return $this->showAlertWithRedirect('با موفقیت وارد شدید', route: 'customer.home');
        } catch (\Exception $e) {
            return $this->showAlertWithRedirect(message:'ورود انجام نشد. دوباره تلاش کنید', title: 'خطا', type: 'error', route: 'auth.login-form');
        }
    }
}

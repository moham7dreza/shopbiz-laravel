<?php

namespace Modules\User\Http\Controllers\Home\Profile;


use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Modules\Share\Http\Controllers\Controller;
use Modules\Share\Traits\ShowMessageWithRedirectTrait;
use Modules\User\Http\Requests\Home\UpdateProfileRequest;
use Modules\User\Services\UserService;

class ProfileController extends Controller
{
    use ShowMessageWithRedirectTrait;

    public UserService $userService;

    /**
     * @return Application|Factory|View
     */
    public function index(): View|Factory|Application
    {
        return view('User::home.profile.profile');
    }

    /**
     * @param UpdateProfileRequest $request
     * @return RedirectResponse
     */
    public function update(UpdateProfileRequest $request): RedirectResponse
    {
        $this->userService->updateUserProfile($request);
        return $this->showToastWithRedirect(title: 'حساب کاربری با موفقیت ویرایش شد', route: 'customer.profile.profile');
//        return to_route('customer.profile.profile')->with('success', 'حساب کاربری با موفقیت ویرایش شد');
    }
}

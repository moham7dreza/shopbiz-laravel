<?php

namespace Modules\User\Http\Controllers\Home\Profile;


use Modules\Share\Http\Controllers\Controller;
use Modules\User\Http\Controllers\Home\UpdateProfileRequest;

class ProfileController extends Controller
{
    public function index()
    {
        return view('User::home.profile.profile');
    }

    public function update(UpdateProfileRequest $request)
    {
        $inputs = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'national_code' => $request->national_code
        ];
        $user = auth()->user();
        $user->update($inputs);
        return redirect()->route('customer.profile.profile')->with('success', 'حساب کاربری با موفقیت ویرایش شد');
    }
}

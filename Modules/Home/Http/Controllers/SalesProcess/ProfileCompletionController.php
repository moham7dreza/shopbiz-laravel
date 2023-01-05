<?php

namespace Modules\Home\Http\Controllers\SalesProcess;

use Illuminate\Support\Facades\Auth;
use Modules\Cart\Entities\CartItem;
use Modules\Share\Http\Controllers\Controller;

class ProfileCompletionController extends Controller
{
    public function profileCompletion()
    {
       $user = Auth::user();

       $cartItems = CartItem::query()->where('user_id', $user->id)->get();
       return view('Home::sales-process.profile-completion', compact('user', 'cartItems'));

    }

    public function update(ProfileCompletionRequest $request)
    {
        $user = Auth::user();
        $national_code = convertArabicToEnglish($request->national_code);
        $national_code = convertPersianToEnglish($national_code);

        $inputs = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'national_code' => $request->national_code,
        ];

        if(isset($request->mobile) && empty($user->mobile))
        {
            $mobile = convertArabicToEnglish($request->mobile);
            $mobile = convertPersianToEnglish($mobile);

            if (preg_match('/^(\+98|98|0)9\d{9}$/', $mobile)) {
                $type = 0; // 0 => mobile

                //all mobile numbers in one format (9**********)
                $mobile = ltrim($mobile, '0');
                $mobile = substr($mobile, 0, 2) == '98' ? substr($mobile, 2) : $mobile;
                $mobile = str_replace('+98', '', $mobile);

                $inputs['mobile'] = $mobile;
            }
            }
            else{
                $errorText = 'فرمت شماره موبایل معتبر نیست';
                return redirect()->back()->withErrors(['mobile', $errorText]);
            }

            if(isset($request->email) && empty($user->email))
            {
                $email = convertArabicToEnglish($request->mobile);
                $email = convertPersianToEnglish($email);

                $inputs['email'] = $email;

            }

            $inputs = array_filter($inputs);

            if(!empty($inputs))
            {
                $user->update($inputs);
            }
            return redirect()->route('customer.sales-process.address-and-delivery');


    }
}

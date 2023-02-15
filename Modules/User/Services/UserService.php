<?php

namespace Modules\User\Services;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Modules\Share\Services\Image\ImageService;
use Modules\Share\Services\ShareService;
use Modules\Share\Traits\ShowMessageWithRedirectTrait;
use Modules\User\Entities\User;
use Modules\User\Notifications\NewUserRegistered;

class UserService
{

    use ShowMessageWithRedirectTrait;

    public ImageService $imageService;

    /**
     * @param ImageService $imageService
     */
    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    /**
     * @param $adminUser
     * @param $userId
     * @return void
     */
    public function sendUserCreatedNotificationToAdmin($adminUser, $userId): void
    {
        $details = [
            'message' => 'یک کاربر جدید در سایت ثبت نام کرد',
            'user_id' => $userId,
        ];
        $adminUser->notify(new NewUserRegistered($details));
    }

    /**
     * Store role with assign permissions.
     *
     * @param  $request
     * @param int $userType
     * @return Builder|Model|string
     */
    public function store($request, int $userType = User::TYPE_USER): Model|Builder|string
    {
        if ($request->hasFile('profile_photo_path')) {
            $result = ShareService::saveImage('users', $request->file('profile_photo_path'), $this->imageService);
            if (!$result) {
                return 'upload failed';
            }
            $request->profile_photo_path = $result;
        } else {
            $request->profile_photo_path = null;
        }
        return $this->query()->create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'mobile' => ShareService::extractMobileNumber($request->mobile),
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'profile_photo_path' => $request->profile_photo_path,
            'activation' => $request->activation,
            'user_type' => $userType,
        ]);
    }

    /**
     * Update role with sync permissions.
     *
     * @param  $request
     * @param $user
     * @return mixed
     */
    public function update($request, $user): mixed
    {
        if ($request->hasFile('profile_photo_path')) {
            if (!empty($user->profile_photo_path)) {
                $this->imageService->deleteImage($user->profile_photo_path);
            }
            $result = ShareService::saveImage('users', $request->file('profile_photo_path'), $this->imageService);

            if (!$result) {
                return 'upload failed';
            }
            $request->profile_photo_path = $result;
        } else {
            if (isset($request->currentImage) && !empty($user->profile_photo_path)) {
                $image = $user->profile_photo_path;
                $image['currentImage'] = $request->currentImage;
                $request->profile_photo_path = $image;
            } else {
                $request->profile_photo_path = $user->profile_photo_path;
            }
        }
        return $user->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'profile_photo_path' => $request->profile_photo_path,
        ]);
    }

    /**
     * @param $request
     * @return mixed
     */
    public function updateUserProfile($request): mixed
    {
        return auth()->user()->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'national_code' => $request->national_code
        ]);
    }


    /**
     * @param $request
     * @return Authenticatable|string|null
     */
    public function profileCompletion($request): string|Authenticatable|null
    {
        $national_code = convertArabicToEnglish($request->national_code);
        $national_code = convertPersianToEnglish($national_code);

        $inputs = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'national_code' => $request->national_code,
        ];

        if (isset($request->mobile) && empty($user->mobile)) {
            $inputs['mobile'] = ShareService::extractMobileNumber($request->mobile);
            if (is_null($inputs['mobile'])) {
                return 'mobile invalid';
//                $errorText = 'فرمت شماره موبایل معتبر نیست';
//                return redirect()->back()->withErrors(['mobile', $errorText]);
            }
        } else {
            return 'mobile invalid';
//            $errorText = 'فرمت شماره موبایل معتبر نیست';
//            return redirect()->back()->withErrors(['mobile', $errorText]);
        }

        if (isset($request->email) && empty($user->email)) {
            $email = convertArabicToEnglish($request->mobile);
            $email = convertPersianToEnglish($email);
            $inputs['email'] = $email;
        }
        $inputs = array_filter($inputs);
        if (!empty($inputs)) {
            auth()->user()->update($inputs);
        }
        return auth()->user();
    }
//    /**
//     * Store user by request.
//     *
//     * @param  $request
//     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
//     */
//    public function store($request)
//    {
//        return $this->query()->create([
//            'name' => $request->name,
//            'email' => $request->email,
//            'phone' => $request->phone,
//            'type' => $request->type,
//            'password' => Hash::make($request->password),
//        ]);
//    }
//
//    /**
//     * Update user with id by request.
//     *
//     * @param  $request
//     * @param  $id
//     * @return int
//     */
//    public function update($request, $id)
//    {
//        return $this->query()->where('id', $id)->update([
//            'name' => $request->name,
//            'email' => $request->email,
//            'phone' => $request->phone,
//            'type' => $request->type,
//        ]);
//    }

    /**
     * Get model(User) query, builder.
     *
     * @return Builder
     */
    private function query(): Builder
    {
        return User::query();
    }
}

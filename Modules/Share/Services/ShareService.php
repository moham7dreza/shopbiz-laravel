<?php

namespace Modules\Share\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Modules\ACL\Entities\Permission;
use Modules\User\Entities\User;

class ShareService
{
    // Permission
    /******************************************************************************************************************/
    /**
     * @param null $user
     * @return bool
     */
    public static function checkForAdmin($user = null): bool
    {
        return self::checkForUserHasSpecialPermission(Permission::PERMISSION_SUPER_ADMIN, user: $user);
    }

    /**
     * @param $permission
     * @param null $user
     * @param int $type
     * @return bool
     */
    public static function checkForUserHasSpecialPermission($permission, $user = null, int $type = User::TYPE_ADMIN): bool
    {
        if (is_null($user)) {
            $user = auth()->user();
        }
        return $user->hasPermissionTo($permission) && ($user->user_type === $type);
    }

    /**
     * @param $permissions
     * @param $user
     * @param int $type
     * @return int
     */
    public static function checkForUserHasSpecialPermissionsCount($permissions, $user = null, int $type = User::TYPE_ADMIN): int
    {
        if (is_null($user)) {
            $user = auth()->user();
        }
        $result = [];
        foreach ($permissions as $permission) {
            if ($user->hasPermissionTo($permission)) {
                $result[] = $permission;
            }
        }
        return $user->user_type === $type ? count($result) : 0;
    }

    // validate Mobile
    /******************************************************************************************************************/
    /**
     * @param $mobileNumber
     * @return array|string|string[]|null
     */
    public static function extractMobileNumber($mobileNumber): array|string|null
    {
        $mobile = convertArabicToEnglish($mobileNumber);
        $mobile = convertPersianToEnglish($mobile);

        if (preg_match('/^(\+98|98|0)9\d{9}$/', $mobile)) {
            $type = 0; // 0 => mobile

            //all mobile numbers in one format (9**********)
            $mobile = ltrim($mobile, '0');
            $mobile = substr($mobile, 0, 2) == '98' ? substr($mobile, 2) : $mobile;
            return str_replace('+98', '', $mobile);
        }
        return null;
    }

    // File upload
    /******************************************************************************************************************/
    /**
     * @param string $directoryName
     * @param $file
     * @param $fileService
     * @param string $saveLocation
     * @return array
     */
    public static function saveFileAndMove(string $directoryName, $file, $fileService, string $saveLocation = 'public'): array
    {
        $fileService->setExclusiveDirectory('files' . DIRECTORY_SEPARATOR . $directoryName);
        $fileService->setFileSize($file);
        $fileSize = $fileService->getFileSize();
        if ($saveLocation = 'public') {
            $result = $fileService->moveToPublic($file);
        } elseif ($saveLocation = 'storage') {
            $result = $fileService->moveToStorage($file);
        } else {
            $result = null;
        }
        $fileFormat = $fileService->getFileFormat();
        return [$result, $fileSize, $fileFormat];
    }

    /******************************************************************************************************************/
    /**
     * the primary timestamp is in ms - we should convert this to second then to date
     *
     * @param $date
     * @return string
     */
    public static function realTimestampDateFormat($date): string
    {
        return date("Y-m-d H:i:s", (int)substr($date, 0, 10));
    }

    // Image intervention
    /******************************************************************************************************************/
    /**
     * @param string $directoryName
     * @param $imageFile
     * @param $imageService
     * @return mixed
     */
    public static function saveImage(string $directoryName, $imageFile, $imageService): mixed
    {
        $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . $directoryName);
        return $imageService->save($imageFile);
    }

    /**
     * @param string $directoryName
     * @param $imageFile
     * @param $imageService
     * @return mixed
     */
    public static function createIndexAndSaveImage(string $directoryName, $imageFile, $imageService): mixed
    {
        $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . $directoryName);
        return $imageService->createIndexAndSave($imageFile);
    }

    /**
     * @param string $directoryName
     * @param $imageFile
     * @param $width
     * @param $height
     * @param $imageService
     * @return mixed
     */
    public static function fitAndSaveImage(string $directoryName, $imageFile, $width, $height, $imageService): mixed
    {
        $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . $directoryName);
        return $imageService->fitAndSave($imageFile, $width, $height);
    }

    /**
     * @param string $directoryName
     * @param $imageFile
     * @param $imageName
     * @param $imageService
     * @return mixed
     */
    public static function saveImageWithName(string $directoryName, $imageFile, $imageName, $imageService): mixed
    {
        $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . $directoryName);
        $imageService->setImageName($imageName);
        return $imageService->save($imageFile);
    }

    // ajax change
    /******************************************************************************************************************/
    /**
     * @param Model $model
     * @return JsonResponse
     */
    public static function changeStatus(Model $model): JsonResponse
    {
        $model->status = $model->status == 0 ? 1 : 0;
        $result = $model->save();
        if ($result) {
            if ($model->status == 0) {
                return response()->json(['status' => true, 'checked' => false]);
            } else {
                return response()->json(['status' => true, 'checked' => true]);
            }
        } else {
            return response()->json(['status' => false]);
        }
    }

    /**
     * @param Model $model
     * @param string $fieldName
     * @return JsonResponse
     */
    public static function ajaxChangeModelSpecialField(Model $model, string $fieldName = 'status'): JsonResponse
    {
        $model->$fieldName = $model->$fieldName == 0 ? 1 : 0;
        $result = $model->save();
        if ($result) {
            if ($model->$fieldName == 0) {
                return response()->json([$fieldName => true, 'checked' => false]);
            } else {
                return response()->json([$fieldName => true, 'checked' => true]);
            }
        } else {
            return response()->json([$fieldName => false]);
        }
    }


    // Sweet Alert
    /******************************************************************************************************************/

        // example:
//        toast('Signed in successfully','success')->timerProgressBar();
        // example:
//        alert()->success('Post Created', 'Successfully')->iconHtml('<i class="far fa-thumbs-up"></i>');
// example:
//       alert()->info('InfoAlert','Lorem ipsum dolor sit amet.')
//            ->animation('animate__animated animate__fadeInDown','animate__animated animate__fadeOutUp')->autoClose(2000);
// example:
//        alert('Title','Lorem Lorem Lorem', 'success')->background('#fff');
// example:
//        alert('Title','Lorem Lorem Lorem', 'success')->width('300px');
// example:
//        alert('Title','Lorem Lorem Lorem', 'success')->width('300px')->padding('50px');
// example:
//        alert()->error('Oops...', 'Something went wrong!')->footer('<a href="#">Why do I have this issue?</a>');
// example:


    /**
     * @param $title
     * @param string $type
     * @param int $timer
     * @return mixed
     */
    public static function showToast($title, string $type = 'success', int $timer = 5000): mixed
    {
        return toast($title, $type)->autoClose($timer)->timerProgressBar();
    }

    /**
     * @param $title
     * @param string $type
     * @param int $timer
     * @return mixed
     */
    public static function showAnimatedToast($title, string $type = 'success', int $timer = 5000): mixed
    {
        return toast($title, $type)->animation('animate__animated animate__fadeInDown', 'animate__animated animate__fadeOutUp')->autoClose($timer)->timerProgressBar();
    }

    /**
     * @param $msg
     * @param string $title
     * @param string $type
     * @param int $timer
     * @return mixed
     */
    public static function showAlert($msg, string $title = 'موفقیت آمیز', string $type = 'success', int $timer = 5000): mixed
    {
        return alert($title, $msg, $type)->autoClose($timer);
    }

    /**
     * @param $msg
     * @param string $title
     * @param string $type
     * @param int $timer
     * @return mixed
     */
    public static function showAnimatedAlert($msg, string $title = 'موفقیت آمیز', string $type = 'success', int $timer = 5000): mixed
    {
        return alert($title, $msg, $type)->animation('animate__animated animate__fadeInDown', 'animate__animated animate__fadeOutUp')->autoClose($timer);
    }

    /**
     * @param $msg
     * @param string $title
     * @param string $type
     * @param int $timer
     * @return mixed
     */
    public static function showAnimatedAlertWithFooter($msg, string $title = 'موفقیت آمیز', string $type = 'success', int $timer = 5000): mixed
    {
        return alert($title, $msg, $type)->animation('animate__animated animate__fadeInDown', 'animate__animated animate__fadeOutUp')
            ->footer('برای ویرایش وارد <a class="text-decoration-none" href="/cart"> <strong>سبد خرید</strong> </a> خود شوید')->autoClose($timer);
    }


    /******************************************************************************************************************/
    /**
     * Convert string to slug.
     *
     * @param string $title
     * @return string
     */
    public static function makeSlug(string $title): string
    {
        return preg_replace('/\s+/', '-', str_replace('_', '', $title));
    }

    /**
     * Make unique sku.
     *
     * @param  $model
     * @return string
     * @throws \Exception
     */
    public static function makeUniqueSku($model): string
    {
        $number = random_int(10000, 99999);

        if ((new self)->checkSKU($model, $number)) {
            return self::makeUniqueSku($model);
        }

        return (string)$number;
    }

    /**
     * Check sku is exists.
     *
     * @param  $model
     * @param int $number
     * @return bool
     */
    private function checkSKU($model, int $number): bool
    {
        return $model::query()->where('sku', $number)->exists();
    }

    /**
     * Upload media with add in request.
     *
     * @param  $request
     * @param string $file
     * @param string $field
     * @return mixed
     */
    public static function uploadMediaWithAddInRequest($request, string $file = 'image', string $field = 'media_id')
    {
        return $request->request->add([$field => MediaFileService::publicUpload($request->file($file))->id]);
    }

    /**
     * Convert text to read minute.
     *
     * @param string $text
     * @return float
     */
    public static function convertTextToReadMinute(string $text): float
    {
        return ceil(str_word_count(strip_tags($text)) / 250);
    }


    /******************************************************************************************************************/
    /**
     * @param $text
     * @return array|string|string[]
     */
    public static function replaceNewLineWithTag($text): array|string
    {
        return str_replace(PHP_EOL, '<br/>', $text);
    }
}

<?php

namespace Modules\Share\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;

class ShareService
{

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
        return [$result, $fileSize , $fileFormat];
    }

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

    /**
     * Show success toast.
     *
     * @param string $title
     * @return mixed
     */
    public static function successToast(string $title)
    {
        return toast($title, 'success')->autoClose(5000);
    }

    /**
     * Show error toast.
     *
     * @param string $title
     * @return mixed
     */
    public static function errorToast(string $title)
    {
        return toast($title, 'error')->autoClose(5000);
    }

    /**
     * Convert string to slug.
     *
     * @param string $title
     * @return string
     */
    public static function makeSlug(string $title)
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
    public static function makeUniqueSku($model)
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
    private function checkSKU($model, int $number)
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
    public static function convertTextToReadMinute(string $text)
    {
        return ceil(str_word_count(strip_tags($text)) / 250);
    }
}

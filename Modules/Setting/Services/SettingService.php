<?php

namespace Modules\Setting\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Modules\Setting\Database\Seeders\SettingSeeder;
use Modules\Setting\Entities\Setting;
use Modules\Setting\Repositories\SettingRepoEloquent;
use Modules\Share\Http\Services\Image\ImageService;
use Modules\Share\Services\ShareService;
use Modules\Share\Traits\SuccessToastMessageWithRedirectTrait;

class SettingService
{
    use SuccessToastMessageWithRedirectTrait;

    public ImageService $imageService;

    /**
     * @param ImageService $imageService
     */
    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    /**
     * @return Model|Builder|null
     */
    public function seedNewSettingIfNotExists(): Model|Builder|null
    {
        $repo = new SettingRepoEloquent();
        $setting = $repo->getSystemSetting();
        if (is_null($setting)) {
            $default = new SettingSeeder();
            $default->run();
            $setting = $repo->getSystemSetting();
        }
        return $setting;
    }

    /**
     * @param $request
     * @param $setting
     * @return mixed
     */
    public function update($request, $setting): mixed
    {
        if ($request->hasFile('logo')) {
            $request->logo = $this->uploadImage($setting->logo, $request->file('logo'), 'logo');
        } else {
            $request->logo = $setting->logo;
        }
        if ($request->hasFile('icon')) {
            $request->icon = $this->uploadImage($setting->icon, $request->file('icon'), 'icon');
        } else {
            $request->icon = $setting->icon;
        }
        return $setting->update([
            'title' => $request->title,
            'description' => $request->description,
            'keywords' => $request->keywords,
            'logo' => $request->logo,
            'icon' => $request->icon,
        ]);
    }

    /**
     * @param $currentImage
     * @param $newImage
     * @param $newImageName
     * @return mixed
     */
    private function uploadImage($currentImage, $newImage, $newImageName): mixed
    {
        if (!empty($currentImage)) {
            $this->imageService->deleteImage($currentImage);
        }
        $result = ShareService::saveImageWithName('setting', $newImage, $newImageName, $this->imageService);
        if (!$result) {
            return $this->successMessageWithRedirect('آپلود تصویر با خطا مواجه شد', 'swal-error');
        }
        return $result;
    }

    /**
     * Get query for model (builder).
     *
     * @return Builder
     */
    private function query(): Builder
    {
        return Setting::query();
    }
}

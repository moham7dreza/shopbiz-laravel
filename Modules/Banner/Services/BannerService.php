<?php

namespace Modules\Banner\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Modules\Banner\Entities\Banner;
use Modules\Share\Services\Image\ImageService;
use Modules\Share\Services\ShareService;
use Modules\Share\Traits\SuccessToastMessageWithRedirectTrait;

class BannerService
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
     * Store role with assign permissions.
     *
     * @param  $request
     * @return Builder|Model|RedirectResponse
     */
    public function store($request): Model|Builder|RedirectResponse
    {
        if ($request->hasFile('image')) {
            $result = ShareService::saveImage('banner', $request->file('image'), $this->imageService);
            if (!$result) {
                return $this->successMessageWithRedirect('آپلود تصویر با خطا مواجه شد', 'swal-error');
            }
            $request->image = $result;
        } else {
            $request->image = null;
        }
        return $this->query()->create([
            'title' => $request->title,
            'image' => $request->image,
            'url' => $request->url,
            'position' => $request->position,
            'status' => $request->status,
        ]);
    }

    /**
     * Update role with sync permissions.
     *
     * @param  $request
     * @param $banner
     * @return mixed
     */
    public function update($request, $banner): mixed
    {
        if ($request->hasFile('image')) {
            if (!empty($banner->image)) {
                $this->imageService->deleteImage($banner->image);
            }
            $result = ShareService::saveImage('banner', $request->file('image'), $this->imageService);

            if ($result === false) {
                return $this->successMessageWithRedirect('آپلود تصویر با خطا مواجه شد', 'swal-error');
            }
            $request->image = $result;
        } else {
            if (isset($request->currentImage) && !empty($banner->image)) {
                $image = $banner->image;
                $image['currentImage'] = $request->currentImage;
                $request->image = $image;
            } else {
                $request->image = $banner->image;
            }
        }
        return $banner->update([
            'title' => $request->title,
            'image' => $request->image,
            'url' => $request->url,
            'position' => $request->position,
            'status' => $request->status,
        ]);
    }

    /**
     * Get query for model (builder).
     *
     * @return Builder
     */
    private function query(): Builder
    {
        return Banner::query();
    }
}

<?php

namespace Modules\Brand\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Modules\Brand\Entities\Brand;
use Modules\Share\Services\Image\ImageService;
use Modules\Share\Services\ShareService;
use Modules\Share\Traits\ShowMessageWithRedirectTrait;

class BrandService
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
     * Store category.
     *
     * @param  $request
     * @return Builder|Model|RedirectResponse
     */
    public function store($request): Model|Builder|RedirectResponse
    {
        if ($request->hasFile('logo')) {
            $result = ShareService::saveImage('brand', $request->file('logo'), $this->imageService);
            if (!$result) {
                return 'upload failed';
            }
            $request->logo = $result;
        } else {
            $request->logo = null;
        }

        return $this->query()->create([
            'persian_name' => $request->persian_name,
            'original_name' => $request->original_name,
            'logo' => $request->logo,
            'status' => $request->status,
            'tags' => $request->tags,
        ]);
    }

    /**
     * @param $request
     * @param $brand
     * @return mixed
     */
    public function update($request, $brand): mixed
    {
        if ($request->hasFile('logo')) {
            if (!empty($brand->logo)) {
                $this->imageService->deleteImage($brand->logo);
            }
            $result = ShareService::saveImage('brand', $request->file('logo'), $this->imageService);

            if (!$result) {
//                return 'upload failed';
            }
            $request->logo = $result;
        } else {
            if (isset($request->currentImage) && !empty($brand->logo)) {
                $logo = $brand->logo;
                $logo['currentImage'] = $request->currentImage;
                $request->logo = $logo;
            } else {
                $request->logo = $brand->logo;
            }
        }

        return $brand->update([
            'persian_name' => $request->persian_name,
            'original_name' => $request->original_name,
            'logo' => $request->logo,
            'status' => $request->status,
            'tags' => $request->tags,
        ]);
    }

    /**
     * Get query for model (builder).
     *
     * @return Builder
     */
    private function query(): Builder
    {
        return Brand::query();
    }
}

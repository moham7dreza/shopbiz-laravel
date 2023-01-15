<?php

namespace Modules\Category\Services\ProductCategory;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Modules\Category\Entities\ProductCategory;
use Modules\Share\Http\Services\Image\ImageService;
use Modules\Share\Services\ShareService;
use Modules\Share\Traits\SuccessToastMessageWithRedirectTrait;

class ProductCategoryService implements ProductCategoryServiceInterface
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
     * Store category.
     *
     * @param  $request
     * @return Builder|Model|RedirectResponse
     */
    public function store($request): Model|Builder|RedirectResponse
    {
        if ($request->hasFile('image')) {
            $result = ShareService::createIndexAndSaveImage('product-category', $request->file('image'), $this->imageService);
            if (!$result) {
                return $this->successMessageWithRedirect('آپلود تصویر با خطا مواجه شد', 'swal-error');
            }
            $request->image = $result;
        } else {
            $request->image = null;
        }

        return $this->query()->create([
            'name' => $request->name,
            'description' => $request->description,
            'image' => $request->image,
            'status' => $request->status,
            'tags' => $request->tags,
            'show_in_menu' => $request->show_in_menu,
            'parent_id' => $request->parent_id,
        ]);
    }

    /**
     * @param $request
     * @param $productCategory
     * @return mixed
     */
    public function update($request, $productCategory): mixed
    {
        if ($request->hasFile('image')) {
            if (!empty($productCategory->image)) {
                $this->imageService->deleteImage($productCategory->image['indexArray']['small']);
                $this->imageService->deleteImage($productCategory->image['indexArray']['medium']);
                $this->imageService->deleteImage($productCategory->image['indexArray']['large']);
            }
            $result = ShareService::createIndexAndSaveImage('product-category', $request->file('image'), $this->imageService);

            if ($result === false) {
                return $this->successMessageWithRedirect('آپلود تصویر با خطا مواجه شد', 'swal-error');
            }
            $request->image = $result;
        } else {
            if (isset($request->currentImage) && !empty($productCategory->image)) {
                $image = $productCategory->image;
                $image['currentImage'] = $request->currentImage;
                $request->image = $image;
            } else {
                $request->image = $productCategory->image;
            }
        }

        return $productCategory->update([
            'name' => $request->name,
            'description' => $request->description,
            'image' => $request->image,
            'status' => $request->status,
            'tags' => $request->tags,
            'show_in_menu' => $request->show_in_menu,
            'parent_id' => $request->parent_id,
        ]);
    }

    /**
     * Return category query.
     *
     * @return Builder
     */
    private function query(): Builder
    {
        return ProductCategory::query();
    }
}

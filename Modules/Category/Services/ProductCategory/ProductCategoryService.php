<?php

namespace Modules\Category\Services\ProductCategory;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Modules\Category\Entities\ProductCategory;
use Modules\Share\Services\Image\ImageService;
use Modules\Share\Services\ShareService;
use Modules\Share\Traits\ShowMessageWithRedirectTrait;

class ProductCategoryService implements ProductCategoryServiceInterface
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
        if ($request->hasFile('image')) {
            $result = ShareService::createIndexAndSaveImage('product-category', $request->file('image'), $this->imageService);
            if (!$result) {
                return $this->showMessageWithRedirect('آپلود تصویر با خطا مواجه شد', 'swal-error');
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
                $this->imageService->deleteDirectoryAndFiles($productCategory->image['directory']);
            }
            $result = ShareService::createIndexAndSaveImage('product-category', $request->file('image'), $this->imageService);

            if ($result === false) {
                return $this->showMessageWithRedirect('آپلود تصویر با خطا مواجه شد', 'swal-error');
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

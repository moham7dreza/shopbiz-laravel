<?php

namespace Modules\Category\Services\PostCategory;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Modules\Category\Entities\PostCategory;
use Modules\Share\Services\Image\ImageService;
use Modules\Share\Services\ShareService;
use Modules\Share\Traits\ShowMessageWithRedirectTrait;

class PostCategoryService implements PostCategoryServiceInterface
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
     * @return Builder|Model|string
     */
    public function store($request): Model|Builder|string
    {
        if ($request->hasFile('image')) {
            $result = ShareService::createIndexAndSaveImage('post-category', $request->file('image'), $this->imageService);
            if (!$result) {
                return 'upload failed';
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
        ]);
    }

    /**
     * @param $request
     * @param $postCategory
     * @return mixed
     */
    public function update($request, $postCategory): mixed
    {
        if ($request->hasFile('image')) {
            if (!empty($postCategory->image)) {
                $this->imageService->deleteDirectoryAndFiles($postCategory->image['directory']);
            }
            $result = ShareService::createIndexAndSaveImage('post-category', $request->file('image'), $this->imageService);

            if (!$result) {
                return 'upload failed';
            }
            $request->image = $result;
        } else {
            if (isset($request->currentImage) && !empty($postCategory->image)) {
                $image = $postCategory->image;
                $image['currentImage'] = $request->currentImage;
                $request->image = $image;
            } else {
                $request->image = $postCategory->image;
            }
        }

        return $postCategory->update([
            'name' => $request->name,
            'description' => $request->description,
            'image' => $request->image,
            'status' => $request->status,
        ]);
    }

    /**
     * Return category query.
     *
     * @return Builder
     */
    private function query(): Builder
    {
        return PostCategory::query();
    }
}

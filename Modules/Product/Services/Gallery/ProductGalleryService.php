<?php

namespace Modules\Product\Services\Gallery;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Modules\Product\Entities\Gallery;
use Modules\Share\Services\Image\ImageService;
use Modules\Share\Services\ShareService;
use Modules\Share\Traits\ShowMessageWithRedirectTrait;

class ProductGalleryService implements ProductGalleryServiceInterface
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
     * @param $productId
     * @return Builder|Model|string
     */
    public function store($request, $productId): Model|Builder|string
    {
        if ($request->hasFile('image')) {
            $result = ShareService::createIndexAndSaveImage('product-gallery', $request->file('image'), $this->imageService);
            if (!$result) {
                return 'upload failed';
            }
            $request->image = $result;
        } else {
            $request->image = null;
            return 'upload failed';
        }

        return $this->query()->create([
            'image' => $request->image,
            'product_id' => $productId,
        ]);
    }

    /**
     * Get product query (builder).
     *
     * @return Builder
     */
    private function query(): Builder
    {
        return Gallery::query();
    }
}

<?php

namespace Modules\Category\Services\ProductCategory;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
use Modules\Category\Entities\ProductCategory;
use Modules\Discount\Entities\AmazingSale;
use Modules\Product\Entities\Product;
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
                return $this->showMessageWithRedirectRoute('آپلود تصویر با خطا مواجه شد', 'swal-error');
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

            if (!$result) {
                return $this->showMessageWithRedirectRoute('آپلود تصویر با خطا مواجه شد', 'swal-error');
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
     * @param $productCategory
     * @return Collection
     */
    public function findProductCategoryBrands($productCategory): Collection
    {
        $brandsCollection = collect();
        foreach ($productCategory->products as $product) {
            $brandsCollection->push($product->brand);
        }
        return $brandsCollection->unique();
    }

    /**
     * @param $productCategory
     * @param $selectedBrands
     * @param $selectedAttrs
     * @param $selectedPriceFrom
     * @param $selectedPriceTo
     * @return mixed
     */
    public function findCategoryProductsByFilter($productCategory, $selectedBrands, $selectedAttrs, $selectedPriceFrom, $selectedPriceTo): mixed
    {
        // all items checked
        if (isset($selectedBrands) && isset($selectedAttrs) && isset($selectedPriceFrom) && isset($selectedPriceTo)) {
            return $productCategory->products()->where([
                ['status', Product::STATUS_ACTIVE],
            ])->latest();
        }   // brands and attrs plus price start
        elseif (!empty($selectedBrands) && !empty($selectedAttrs) && !empty($selectedPriceFrom)) {
            return $productCategory->products()->where([
                ['status', Product::STATUS_ACTIVE],
            ])->latest();
        }   // brands and attrs plus price end
        elseif (!empty($selectedBrands) && !empty($selectedAttrs) && !empty($selectedPriceTo)) {
            return $productCategory->products()->where([
                ['status', Product::STATUS_ACTIVE],
            ])->latest();
        }   // select brands and prices
        elseif (!empty($selectedBrands) && !empty($selectedPriceFrom) && !empty($selectedPriceTo)) {
            return $productCategory->products()->where([
                ['status', Product::STATUS_ACTIVE],
            ])->latest();
        } elseif (!empty($selectedBrands) && !empty($selectedPriceFrom)) {
            return $productCategory->products()->where([
                ['status', Product::STATUS_ACTIVE],
            ])->latest();
        } elseif (!empty($selectedBrands) && !empty($selectedPriceTo)) {
            return $productCategory->products()->where([
                ['status', Product::STATUS_ACTIVE],
            ])->latest();
        }    // select attrs and prices
        elseif (!empty($selectedAttrs) && !empty($selectedPriceFrom) && !empty($selectedPriceTo)) {
            return $productCategory->products()->where([
                ['status', Product::STATUS_ACTIVE],
            ])->latest();
        } elseif (!empty($selectedAttrs) && !empty($selectedPriceFrom)) {
            return $productCategory->products()->where([
                ['status', Product::STATUS_ACTIVE],
            ])->latest();
        } elseif (!empty($selectedAttrs) && !empty($selectedPriceTo)) {
            return $productCategory->products()->where([
                ['status', Product::STATUS_ACTIVE],
            ])->latest();
        }   // only prices
        elseif (!empty($selectedPriceFrom) && !empty($selectedPriceTo)) {
            return $productCategory->products()->where([
                ['status', Product::STATUS_ACTIVE],
            ])->latest();
        }   // single checks
        elseif (!empty($selectedBrands)) {
            return $productCategory->products()->where([
                ['status', Product::STATUS_ACTIVE],
            ])->latest();
        } elseif (!empty($selectedAttrs)) {
            return $productCategory->products()->where([
                ['status', Product::STATUS_ACTIVE],
            ])->latest();
        } elseif (!empty($selectedPriceFrom)) {
            return $productCategory->products()->where([
                ['status', Product::STATUS_ACTIVE],
            ])->latest();
        } elseif (!empty($selectedPriceTo)) {
            return $productCategory->products()->where([
                ['status', Product::STATUS_ACTIVE],
            ])->latest();
        } else {
            return $productCategory->products()->where([
                ['status', Product::STATUS_ACTIVE],
            ])->latest();
        }
    }

    /**
     * @param $productCategory
     * @param $type
     * @return mixed
     */
    public function findCategoryProductsByType($productCategory, $type): mixed
    {
        if ($type === 'newest') {
            return $productCategory->products()->where([
                ['status', Product::STATUS_ACTIVE],
            ])->latest();
        } elseif ($type === 'popular') {
            return $productCategory->products()->where([
                ['status', Product::STATUS_ACTIVE],
                ['sold_number', '>=', 0],
            ])->latest();
        } elseif ($type === 'expensive') {
            return $productCategory->products()->where([
                ['status', Product::STATUS_ACTIVE],
            ])->orderBy('price', 'desc')->latest();
        } elseif ($type === 'cheapest') {
            return $productCategory->products()->where([
                ['status', Product::STATUS_ACTIVE],
            ])->orderBy('price', 'asc')->latest();
        } elseif ($type === 'mostVisited') {
            return $productCategory->products()->where([
                ['status', Product::STATUS_ACTIVE],
                ['sold_number', '>=', 0],
            ])->latest();
        } elseif ($type === 'bestSales') {
            return $productCategory->products()->where([
                ['status', Product::STATUS_ACTIVE],
                ['sold_number', '>=', 1],
            ])->latest();
        } elseif (isset($type)) {
            return $productCategory->products()->where([
                ['status', Product::STATUS_ACTIVE],
                ['name', 'like', '%' . $type . '%'],
            ])->latest();
        } else {
            return $productCategory->products()->latest();
        }
    }

    /**
     * @param $activeAmazingSales
     * @param $type
     * @return mixed
     */
    public function findOfferedProductsByType($activeAmazingSales, $type): mixed
    {
        $products = collect();
        foreach ($activeAmazingSales as $activeAmazingSale) {
            $products->push($activeAmazingSale->product->id);
        }
        $products = $products->unique();
        if ($type === 'newest') {
            return AmazingSale::query()->whereIn('product_id', $products->values())->latest();
        } elseif ($type === 'popular') {
            $products = Product::query()->whereIn('id', $products->values())->where('sold_number', '>=', 2)->pluck('id');
            return AmazingSale::query()->whereIn('product_id', $products->values())->latest();
        } elseif ($type === 'expensive') {
            return $productCategory->products()->where([
                ['status', Product::STATUS_ACTIVE],
            ])->orderBy('price', 'desc')->latest();
        } elseif ($type === 'cheapest') {
            return $productCategory->products()->where([
                ['status', Product::STATUS_ACTIVE],
            ])->orderBy('price', 'asc')->latest();
        } elseif ($type === 'mostVisited') {
            return $productCategory->products()->where([
                ['status', Product::STATUS_ACTIVE],
                ['sold_number', '>=', 0],
            ])->latest();
        } elseif ($type === 'bestSales') {
            return $productCategory->products()->where([
                ['status', Product::STATUS_ACTIVE],
                ['sold_number', '>=', 1],
            ])->latest();
        } elseif (isset($type)) {
            return $productCategory->products()->where([
                ['status', Product::STATUS_ACTIVE],
                ['name', 'like', '%' . $type . '%'],
            ])->latest();
        } else {
            return $productCategory->products()->latest();
        }
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

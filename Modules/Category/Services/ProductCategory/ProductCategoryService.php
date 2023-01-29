<?php

namespace Modules\Category\Services\ProductCategory;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Modules\Attribute\Entities\AttributeValue;
use Modules\Category\Entities\ProductCategory;
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
     * @param $selectedBrands
     * @param $selectedValues
     * @param $selectedPriceFrom
     * @param $selectedPriceTo
     * @return mixed
     */
    public function findCategoryProductsByFilter($productCategory, $selectedBrands, $selectedValues, $selectedPriceFrom, $selectedPriceTo): mixed
    {
        $products = $productCategory->products()->where([
            ['status', Product::STATUS_ACTIVE],
        ]);
        // all items checked
        if (isset($selectedBrands) && isset($selectedAttrs) && isset($selectedPriceFrom) && isset($selectedPriceTo)) {
            $selectedBrandProductIds = $products->whereIn('brand_id', $selectedBrands)->pluck('id');
            $productIds = AttributeValue::query()->whereIn('id', $selectedValues)
                ->whereIn('product_id', $selectedBrandProductIds)->pluck('product_id');
            return Product::query()->whereIn('id', $productIds)->where([
                ['status', Product::STATUS_ACTIVE],
                ['price', '>', $selectedPriceFrom],
                ['price', '<', $selectedPriceTo],
            ])->latest();
        }   // brands and attrs plus price start
        elseif (!empty($selectedBrands) && !empty($selectedValues) && !empty($selectedPriceFrom)) {
            $selectedBrandProductIds = $products->whereIn('brand_id', $selectedBrands)->pluck('id');
            $productIds = AttributeValue::query()->whereIn('id', $selectedValues)
                ->whereIn('product_id', $selectedBrandProductIds)->pluck('product_id');
            return Product::query()->whereIn('id', $productIds)->where([
                ['status', Product::STATUS_ACTIVE],
                ['price', '>', $selectedPriceFrom],
            ])->latest();
        }   // brands and attrs plus price end
        elseif (!empty($selectedBrands) && !empty($selectedValues) && !empty($selectedPriceTo)) {
            $selectedBrandProductIds = $products->whereIn('brand_id', $selectedBrands)->pluck('id');
            $productIds = AttributeValue::query()->whereIn('id', $selectedValues)
                ->whereIn('product_id', $selectedBrandProductIds)->pluck('product_id');
            return Product::query()->whereIn('id', $productIds)->where([
                ['status', Product::STATUS_ACTIVE],
                ['price', '<', $selectedPriceTo],
            ])->latest();
        } elseif (!empty($selectedBrands) && !empty($selectedValues)) {
            $selectedBrandProductIds = $products->whereIn('brand_id', $selectedBrands)->pluck('id');
            $productIds = AttributeValue::query()->whereIn('id', $selectedValues)
                ->whereIn('product_id', $selectedBrandProductIds)->pluck('product_id');
            return Product::query()->whereIn('id', $productIds)->where([
                ['status', Product::STATUS_ACTIVE],
            ])->latest();
        }// select brands and prices
        elseif (!empty($selectedBrands) && !empty($selectedPriceFrom) && !empty($selectedPriceTo)) {
            return $products->whereIn('brand_id', $selectedBrands)->where([
                ['status', Product::STATUS_ACTIVE],
                ['price', '>', $selectedPriceFrom],
                ['price', '<', $selectedPriceTo],
            ])->latest();
        } elseif (!empty($selectedBrands) && !empty($selectedPriceFrom)) {
            return $products->whereIn('brand_id', $selectedBrands)->where([
                ['status', Product::STATUS_ACTIVE],
                ['price', '>', $selectedPriceFrom],
            ])->latest();
        } elseif (!empty($selectedBrands) && !empty($selectedPriceTo)) {
            return $products->whereIn('brand_id', $selectedBrands)->where([
                ['status', Product::STATUS_ACTIVE],
                ['price', '<', $selectedPriceTo],
            ])->latest();
        }    // select attrs and prices
        elseif (!empty($selectedValues) && !empty($selectedPriceFrom) && !empty($selectedPriceTo)) {
            $productIds = AttributeValue::query()->whereIn('id', $selectedValues)->pluck('product_id');
            return Product::query()->whereIn('id', $productIds)->where([
                ['status', Product::STATUS_ACTIVE],
                ['price', '>', $selectedPriceFrom],
                ['price', '<', $selectedPriceTo],
            ])->latest();
        } elseif (!empty($selectedValues) && !empty($selectedPriceFrom)) {
            $productIds = AttributeValue::query()->whereIn('id', $selectedValues)->pluck('product_id');
            return Product::query()->whereIn('id', $productIds)->where([
                ['status', Product::STATUS_ACTIVE],
                ['price', '>', $selectedPriceFrom]
            ])->latest();
        } elseif (!empty($selectedValues) && !empty($selectedPriceTo)) {
            $productIds = AttributeValue::query()->whereIn('id', $selectedValues)->pluck('product_id');
            return Product::query()->whereIn('id', $productIds)->where([
                ['status', Product::STATUS_ACTIVE],
                ['price', '<', $selectedPriceTo]
            ])->latest();
        }   // only prices
        elseif (!empty($selectedPriceFrom) && !empty($selectedPriceTo)) {
            return $products->where([
                ['status', Product::STATUS_ACTIVE],
                ['price', '>', $selectedPriceFrom],
                ['price', '<', $selectedPriceTo],
            ])->latest();
        }   // single checks
        elseif (!empty($selectedBrands)) {
            return $products->whereIn('brand_id', $selectedBrands)->latest();
        }
        elseif (!empty($selectedValues)) {
            $productIds = AttributeValue::query()->whereIn('id', $selectedValues)->pluck('product_id');
            return Product::query()->whereIn('id', $productIds)->latest();
        }
        elseif (!empty($selectedPriceFrom)) {
            return $products->where([
                ['status', Product::STATUS_ACTIVE],
                ['price', '>', $selectedPriceFrom]
            ])->latest();
        } elseif (!empty($selectedPriceTo)) {
            return $products->where([
                ['status', Product::STATUS_ACTIVE],
                ['price', '<', $selectedPriceTo]
            ])->latest();
        } else {
            return $products->latest();
        }
    }

    /**
     * @param $productCategory
     * @param $type
     * @return mixed
     */
    public function findCategoryProductsByType($productCategory, $type): mixed
    {
        $products = $productCategory->products()->where([
            ['status', Product::STATUS_ACTIVE],
        ]);
        if ($type === 'newest') {
            return $products->latest();
        } elseif ($type === 'popular') {
            return $products->where([
                ['sold_number', '>=', 0],
            ])->latest();
        } elseif ($type === 'expensive') {
            return $products->orderBy('price', 'desc')->latest();
        } elseif ($type === 'cheapest') {
            return $products->orderBy('price', 'asc')->latest();
        } elseif ($type === 'mostVisited') {
            return $products->where([
                ['sold_number', '>=', 0],
            ])->latest();
        } elseif ($type === 'bestSales') {
            return $products->where([
                ['sold_number', '>=', 1],
            ])->latest();
        } elseif (isset($type)) {
            return $products->where([
                ['name', 'like', '%' . $type . '%'],
            ])->latest();
        } else {
            return $products->latest();
        }
    }

    /**
     * @param $productIds
     * @param $type
     * @return mixed
     */
    public function findOfferedProductsByType($productIds, $type): mixed
    {
        $products = Product::query()->whereIn('id', $productIds);
        if ($type === 'newest') {
            return $products->latest();
        } elseif ($type === 'popular') {
            return $products->where('sold_number', '>=', 1)->latest();
        } elseif ($type === 'expensive') {
            return $products->orderBy('price', 'desc')->latest();
        } elseif ($type === 'cheapest') {
            return $products->orderBy('price', 'asc')->latest();
        } elseif ($type === 'mostVisited') {
            return $products->latest();
        } elseif ($type === 'bestSales') {
            return $products->where('sold_number', '>=', 1)->latest();
        } elseif (isset($type)) {
            return $products->where([
                ['status', Product::STATUS_ACTIVE],
                ['name', 'like', '%' . $type . '%'],
            ])->latest();
        } else {
            return $products->latest();
        }
    }

    /**
     * @param $productIds
     * @param $selectedBrands
     * @param $selectedValues
     * @param $selectedPriceFrom
     * @param $selectedPriceTo
     * @return mixed
     */
    public function findOfferedProductsByFilter($productIds, $selectedBrands, $selectedValues, $selectedPriceFrom, $selectedPriceTo): mixed
    {
        $products = Product::query()->whereIn('id', $productIds)->where([
            ['status', Product::STATUS_ACTIVE],
        ]);
        // all items checked
        if (isset($selectedBrands) && isset($selectedAttrs) && isset($selectedPriceFrom) && isset($selectedPriceTo)) {
            $selectedBrandProductIds = $products->whereIn('brand_id', $selectedBrands)->pluck('id');
            $productIds = AttributeValue::query()->whereIn('id', $selectedValues)
                ->whereIn('product_id', $selectedBrandProductIds)->pluck('product_id');
            return Product::query()->whereIn('id', $productIds)->where([
                ['status', Product::STATUS_ACTIVE],
                ['price', '>', $selectedPriceFrom],
                ['price', '<', $selectedPriceTo],
            ])->latest();
        }   // brands and attrs plus price start
        elseif (!empty($selectedBrands) && !empty($selectedValues) && !empty($selectedPriceFrom)) {
            $selectedBrandProductIds = $products->whereIn('brand_id', $selectedBrands)->pluck('id');
            $productIds = AttributeValue::query()->whereIn('id', $selectedValues)
                ->whereIn('product_id', $selectedBrandProductIds)->pluck('product_id');
            return Product::query()->whereIn('id', $productIds)->where([
                ['status', Product::STATUS_ACTIVE],
                ['price', '>', $selectedPriceFrom],
            ])->latest();
        }   // brands and attrs plus price end
        elseif (!empty($selectedBrands) && !empty($selectedValues) && !empty($selectedPriceTo)) {
            $selectedBrandProductIds = $products->whereIn('brand_id', $selectedBrands)->pluck('id');
            $productIds = AttributeValue::query()->whereIn('id', $selectedValues)
                ->whereIn('product_id', $selectedBrandProductIds)->pluck('product_id');
            return Product::query()->whereIn('id', $productIds)->where([
                ['status', Product::STATUS_ACTIVE],
                ['price', '<', $selectedPriceTo],
            ])->latest();
        } elseif (!empty($selectedBrands) && !empty($selectedValues)) {
            $selectedBrandProductIds = $products->whereIn('brand_id', $selectedBrands)->pluck('id');
            $productIds = AttributeValue::query()->whereIn('id', $selectedValues)
                ->whereIn('product_id', $selectedBrandProductIds)->pluck('product_id');
            return Product::query()->whereIn('id', $productIds)->where([
                ['status', Product::STATUS_ACTIVE],
            ])->latest();
        }// select brands and prices
        elseif (!empty($selectedBrands) && !empty($selectedPriceFrom) && !empty($selectedPriceTo)) {
            return $products->whereIn('brand_id', $selectedBrands)->where([
                ['status', Product::STATUS_ACTIVE],
                ['price', '>', $selectedPriceFrom],
                ['price', '<', $selectedPriceTo],
            ])->latest();
        } elseif (!empty($selectedBrands) && !empty($selectedPriceFrom)) {
            return $products->whereIn('brand_id', $selectedBrands)->where([
                ['status', Product::STATUS_ACTIVE],
                ['price', '>', $selectedPriceFrom],
            ])->latest();
        } elseif (!empty($selectedBrands) && !empty($selectedPriceTo)) {
            return $products->whereIn('brand_id', $selectedBrands)->where([
                ['status', Product::STATUS_ACTIVE],
                ['price', '<', $selectedPriceTo],
            ])->latest();
        }    // select attrs and prices
        elseif (!empty($selectedValues) && !empty($selectedPriceFrom) && !empty($selectedPriceTo)) {
            $productIds = AttributeValue::query()->whereIn('id', $selectedValues)->pluck('product_id');
            return Product::query()->whereIn('id', $productIds)->where([
                ['status', Product::STATUS_ACTIVE],
                ['price', '>', $selectedPriceFrom],
                ['price', '<', $selectedPriceTo],
            ])->latest();
        } elseif (!empty($selectedValues) && !empty($selectedPriceFrom)) {
            $productIds = AttributeValue::query()->whereIn('id', $selectedValues)->pluck('product_id');
            return Product::query()->whereIn('id', $productIds)->where([
                ['status', Product::STATUS_ACTIVE],
                ['price', '>', $selectedPriceFrom]
            ])->latest();
        } elseif (!empty($selectedValues) && !empty($selectedPriceTo)) {
            $productIds = AttributeValue::query()->whereIn('id', $selectedValues)->pluck('product_id');
            return Product::query()->whereIn('id', $productIds)->where([
                ['status', Product::STATUS_ACTIVE],
                ['price', '<', $selectedPriceTo]
            ])->latest();
        }   // only prices
        elseif (!empty($selectedPriceFrom) && !empty($selectedPriceTo)) {
            return $products->where([
                ['status', Product::STATUS_ACTIVE],
                ['price', '>', $selectedPriceFrom],
                ['price', '<', $selectedPriceTo],
            ])->latest();
        }   // single checks
        elseif (!empty($selectedBrands)) {
            return $products->whereIn('brand_id', $selectedBrands)->latest();
        } elseif (!empty($selectedValues)) {
            $productIds = AttributeValue::query()->whereIn('id', $selectedValues)->pluck('product_id');
            return Product::query()->whereIn('id', $productIds)->latest();
        } elseif (!empty($selectedPriceFrom)) {
            return $products->where([
                ['status', Product::STATUS_ACTIVE],
                ['price', '>', $selectedPriceFrom]
            ])->latest();
        } elseif (!empty($selectedPriceTo)) {
            return $products->where([
                ['status', Product::STATUS_ACTIVE],
                ['price', '<', $selectedPriceTo]
            ])->latest();
        } else {
            return $products->latest();
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

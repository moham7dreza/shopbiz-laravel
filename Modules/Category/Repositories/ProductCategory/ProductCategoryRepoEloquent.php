<?php

namespace Modules\Category\Repositories\ProductCategory;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Modules\Category\Entities\ProductCategory;
use Modules\Product\Entities\Product;

class ProductCategoryRepoEloquent implements ProductCategoryRepoEloquentInterface
{
    private string $class = ProductCategory::class;

    /**
     * @param $name
     * @return Model|Builder|null
     */
    public function search($name): Model|Builder|null
    {
        return $this->query()->where('name', 'like', '%' . $name . '%')
            ->orWhere('description', 'like', '%' . $name . '%')->latest();
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
     * Get latest categories.
     *
     * @return Builder
     */
    public function getLatestCategories(): Builder
    {
        return $this->query()->latest();
    }

    /**
     * @param $field
     * @param $value
     * @return Builder
     */
    public function searchByCol($field, $value): Builder
    {
        return $this->query()->where($field, 'like', '%' . $value . '%')->latest();
    }

    /**
     * Find category by id.
     *
     * @param  $id
     * @return Builder|Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public function findById($id)
    {
        return $this->query()->findOrFail($id);
    }

    /**
     * Delete category by id.
     *
     * @param  $id
     * @return mixed
     */
    public function delete($id)
    {
        return $this->query()->where('id', $id)->delete();
    }

    /**
     * Change status by id.
     *
     * @param  $id
     * @param string $status
     * @return int
     */
    public function changeStatus($id, string $status)
    {
        return $this->query()->where('id', $id)->update(['status' => $status]);
    }

    /**
     * Get active categories.
     *
     * @return Builder
     */
    public function getActiveCategories(): Builder
    {
        return $this->query()->where('status', $this->class::STATUS_ACTIVE);
    }

    /**
     * @param $slug
     * @return Builder|Model|object|null
     */
    public function findBySlug($slug)
    {
        return $this->query()->where([
            ['status', $this->class::STATUS_ACTIVE],
            ['slug', $slug]
        ])->first();
    }

    /**
     * @return Builder
     */
    public function getParentCategories(): Builder
    {
        return $this->query()->where('parent_id', null)->latest();
    }

    /**
     * @return Builder
     */
    public function getShowInMenuActiveParentCategories(): Builder
    {
        return $this->query()->where([
            ['status', $this->class::SHOW_IN_MENU],
            ['show_in_menu', $this->class::STATUS_ACTIVE],
            ['parent_id', NULL]
        ])->latest();
    }

    /**
     * Get query model (builder).
     *
     * @return Builder
     */
    private function query(): Builder
    {
        return $this->class::query();
    }
}

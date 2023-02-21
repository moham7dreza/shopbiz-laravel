<?php

namespace Modules\Product\Repositories\Product;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Modules\Product\Entities\Product;

class ProductRepoEloquent implements ProductRepoEloquentInterface
{
    /**
     * @param $name
     * @return Model|Builder|null
     */
    public function search($name): Model|Builder|null
    {
        return $this->query()->where('name', 'like', '%' . $name . '%')
            ->orWhere('introduction', 'like', '%' . $name . '%')->latest();
    }

    /**
     * used in panel
     * @return int
     */
    public function productsCount(): int
    {
        return $this->query()->count();
    }

    /**
     * used in panel
     * @return int
     */
    public function lowNumberProductsCount(): int
    {
        return $this->query()->lowMarketableNumber()->count();
    }

    /**
     * used in panel
     * @return int
     */
    public function lowViewProductsCount(): int
    {
        return $this->query()->lowViewNumber()->count();
    }

    /**
     * Get latest products.
     *
     * @return Builder
     */
    public function index(): Builder
    {
        return $this->query()->latest();
    }

    //***************************************************** Home queries ******************************************* //

    /**
     * @param $name
     * @return Model|Builder|null
     */
    public function searchReadyForSaleProducts($name): Model|Builder|null
    {
        return $this->query()->readyForSale()->where('name', 'like', '%' . $name . '%')
            ->orWhere('introduction', 'like', '%' . $name . '%')->latest();
    }

    /**
     * find related products in cart from cart items
     * @param $products
     * @return Collection
     */
    public function findRelatedProducts($products): Collection
    {
        $categoryProducts = collect();
        foreach ($products as $product) {
            $categoryProducts->push($product->category->products()->readyForSale()->get());
        }
        return $categoryProducts->collapse()->shuffle()->take(10);
    }

    /**
     * @param string $direction
     * @return mixed
     */
    public function orderByMarketableNumber(string $direction = 'asc'): mixed
    {
        return $this->query()->readyForSale()->orderBy('marketable_number', $direction);
    }


    /**
     * @param $product
     * @return mixed
     */
    public function relatedItems($product): mixed
    {
        return $product->category->products()->readyForSale()->where('id', '!=', $product->id)->latest();
    }

    /**
     * @return Builder
     */
    public function orderByPublishedAt(): Builder
    {
        return $this->query()->readyForSale()->orderBy('published_at', 'desc');
    }

    /**
     * @return mixed
     */
    public function orderByViews(): mixed
    {
        return $this->query()->readyForSale()->orderByUniqueViews();
    }

    /**
     * @return mixed
     */
    public function offers(): mixed
    {
        return $this->query()->readyForSale()->selected()->latest();
    }

    /**
     * @return mixed
     */
    public function popular(): mixed
    {
        return $this->query()->readyForSale()->popular()->latest();
    }

    /**
     * @param $soldNumber
     * @return Builder
     */
    public function bestSeller($soldNumber): Builder
    {
        return $this->query()->readyForSale()->where('sold_number', '>=', $soldNumber)->latest();
    }

    /**
     * primary site search using
     * @param $field
     * @param $value
     * @return Builder
     */
    public function searchByCol($field, $value): Builder
    {
        return $this->query()->where($field, 'like', '%' . $value . '%')->latest();
    }

    // ******************************************************************************

    /**
     * @param string $direction
     * @return mixed
     */
    public function allProductsOrderByMarketableNumber(string $direction = 'asc'): mixed
    {
        return $this->query()->orderBy('marketable_number', $direction);
    }

    /**
     * Find product by id.
     *
     * @param  $id
     * @return Builder|Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public function findById($id)
    {
        return $this->query()->findOrFail($id);
    }

    /**
     * Delete product by id.
     *
     * @param  $id
     * @return mixed
     */
    public function delete($id)
    {
        return $this->query()->where('id', $id)->delete();
    }

    // home


    /**
     * @param $product
     * @return mixed
     */
    public function getUserReviewedProductRate($product): mixed
    {
        return $product->reviews()->user()->pluck('rate')->last();
    }

    /**
     * @return Collection
     */
    public function findHasActiveAmazingSales(): Collection
    {
        $products = $this->index()->get();
        $actives = collect();
        foreach ($products as $product) {
            if ($product->activeAmazingSales()) {
                $actives->push($product);
            }
        }
        return $actives->unique();
    }

    /**
     * @return Builder
     */
    public function lowMarketableNumber(): Builder
    {
        return $this->query()->lowMarketableNumber()->latest();
    }

    /**
     * Get query model (builder).
     *
     * @return Builder
     */
    private function query(): Builder
    {
        return Product::query();
    }
}

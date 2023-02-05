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
     * @return int
     */
    public function productsCount(): int
    {
        return $this->index()->count();
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

    /**
     * @param string $direction
     * @return mixed
     */
    public function orderByMarketableNumber(string $direction = 'asc'): mixed
    {
        return $this->query()->active()->orderBy('marketable_number', $direction);
    }

    /**
     * @param $product
     * @return mixed
     */
    public function relatedItems($product): mixed
    {
        return $product->category->products()->where('id', '!=', $product->id)->latest();
    }

    /**
     * @return Builder
     */
    public function orderByPublishedAt(): Builder
    {
        return $this->query()->where('status', 1)->orderBy('published_at', 'desc');
//        return $this->query()->active()->latest()-orderBy('published_at', 'desc');
    }

    /**
     * @return mixed
     */
    public function orderByViews(): mixed
    {
        return $this->query()->active()->orderByUniqueViews();
    }

    /**
     * @return mixed
     */
    public function offers(): mixed
    {
        return $this->query()->active()->selected()->latest();
    }

    /**
     * @return mixed
     */
    public function popular(): mixed
    {
        return $this->query()->active()->popular()->latest();
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
     * @param $soldNumber
     * @return Builder
     */
    public function bestSeller($soldNumber): Builder
    {
        return $this->query()->where([
            ['status', Product::STATUS_ACTIVE],
            ['sold_number', '>=', $soldNumber],
        ])->latest();
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
     * Get query model (builder).
     *
     * @return Builder
     */
    private function query(): Builder
    {
        return Product::query();
    }
}

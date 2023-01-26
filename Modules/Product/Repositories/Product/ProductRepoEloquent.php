<?php

namespace Modules\Product\Repositories\Product;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Modules\Product\Entities\Product;

class ProductRepoEloquent implements ProductRepoEloquentInterface
{

    /**
     * @param $name
     * @param $productId
     * @return Model|Builder|null
     */
    public function search($name): Model|Builder|null
    {
        return $this->query()->where('name', 'like', '%' . $name . '%')
            ->orWhere('introduction', 'like', '%' . $name . '%')->latest();
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
     * Get query model (builder).
     *
     * @return Builder
     */
    private function query(): Builder
    {
        return Product::query();
    }
}

<?php

namespace Modules\Product\Repositories\Color;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\ProductColor;

class ProductColorRepoEloquent implements ProductColorRepoEloquentInterface
{

    /**
     * @param $name
     * @param $productId
     * @return Model|Builder|null
     */
    public function search($name, $productId): Model|Builder|null
    {
        return $this->query()->where([['product_id', $productId], ['color_name' , 'like', '%' . $name . '%']])
            ->orWhere([['product_id', $productId], ['color' , 'like', '%' . $name . '%']])->latest();
    }
    /**
     * Get latest products.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function getLatest()
    {
        return $this->query()->latest();
    }

    /**
     * Find product by id.
     *
     * @param  $id
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
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

    /**
     * Get query model (builder).
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    private function query(): \Illuminate\Database\Eloquent\Builder
    {
        return ProductColor::query();
    }
}

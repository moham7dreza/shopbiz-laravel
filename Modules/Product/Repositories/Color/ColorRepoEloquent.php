<?php

namespace Modules\Product\Repositories\Color;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Modules\Product\Entities\Color;

class ColorRepoEloquent implements ColorRepoEloquentInterface
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
     * @return Builder
     */
    public function getLatest(): Builder
    {
        return $this->query()->latest();
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

    /**
     * Get query model (builder).
     *
     * @return Builder
     */
    private function query(): Builder
    {
        return Color::query();
    }
}

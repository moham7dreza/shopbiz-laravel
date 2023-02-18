<?php

namespace Modules\Product\Repositories\Guarantee;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Modules\Product\Entities\Guarantee;
use Modules\Product\Entities\Product;

class GuaranteeRepoEloquent implements GuaranteeRepoEloquentInterface
{

    /**
     * @param $name
     * @param $productId
     * @return Model|Builder|null
     */
    public function search($name, $productId): Model|Builder|null
    {
        return $this->query()->where([['product_id', $productId], ['name' , 'like', '%' . $name . '%']])->latest();
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
     * Change status by id.
     *
     * @param  $id
     * @param  string $status
     * @return int
     */
    public function changeStatus($id, string $status)
    {
        return $this->query()->where('product_id', $id)->update(['status' => $status]);
    }

    /**
     * Get query model (builder).
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    private function query(): \Illuminate\Database\Eloquent\Builder
    {
        return Guarantee::query();
    }
}

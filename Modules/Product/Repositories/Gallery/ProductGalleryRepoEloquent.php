<?php

namespace Modules\Product\Repositories\Gallery;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Modules\Product\Entities\Gallery;
use Modules\Product\Entities\Product;

class ProductGalleryRepoEloquent implements ProductGalleryRepoEloquentInterface
{


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
        return Gallery::query();
    }
}

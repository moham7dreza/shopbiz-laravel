<?php

namespace Modules\Category\Repositories\ProductCategory;

use Modules\Category\Entities\ProductCategory;
use Modules\Category\Repositories\ProductCategoryRepoEloquentInterface;

class ProductCategoryRepoEloquent implements ProductCategoryRepoEloquentInterface
{
    /**
     * Get latest categories.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function getLatestCategories()
    {
        return $this->query()->latest();
    }

    /**
     * Find category by id.
     *
     * @param  $id
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
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
     * @param  string $status
     * @return int
     */
    public function changeStatus($id, string $status)
    {
        return $this->query()->where('id', $id)->update(['status' => $status]);
    }

    /**
     * Get active categories.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function getActiveCategories()
    {
        return $this->query()->where('status', ProductCategory::STATUS_ACTIVE);
    }

    /**
     * Get query model (builder).
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    private function query()
    {
        return ProductCategory::query();
    }
}

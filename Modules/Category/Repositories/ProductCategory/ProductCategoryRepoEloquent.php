<?php

namespace Modules\Category\Repositories\ProductCategory;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Modules\Category\Entities\ProductCategory;

class ProductCategoryRepoEloquent implements ProductCategoryRepoEloquentInterface
{
    private string $class = ProductCategory::class;

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
     * Get query model (builder).
     *
     * @return Builder
     */
    private function query(): Builder
    {
        return $this->class::query();
    }
}

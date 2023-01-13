<?php

namespace Modules\Category\Repositories\PostCategory;

use Illuminate\Database\Eloquent\Builder;
use Modules\Category\Entities\PostCategory;
use Modules\Category\Entities\ProductCategory;

class PostCategoryRepoEloquent implements PostCategoryRepoEloquentInterface
{
    private string $class = PostCategory::class;

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
    public function getActiveCategories()
    {
        return $this->query()->where('status', $this->class::STATUS_ACTIVE);
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

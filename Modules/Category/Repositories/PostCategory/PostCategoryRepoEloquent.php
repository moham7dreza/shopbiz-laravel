<?php

namespace Modules\Category\Repositories\PostCategory;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Modules\Category\Entities\PostCategory;

class PostCategoryRepoEloquent implements PostCategoryRepoEloquentInterface
{
    private string $class = PostCategory::class;

    /**
     * @param $property
     * @param $dir
     * @return Builder
     */
    public function sort($property, $dir): Builder
    {
        return $this->query()->orderBy($property, $dir);
    }

    /**
     * @param $name
     * @return Model|Builder|null
     */
    public function search($name): Model|Builder|null
    {
        return $this->query()->where('name', 'like', '%' . $name . '%')
            ->orWhere('description', 'like', '%' . $name . '%')->latest();
    }

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
     * @return mixed
     */
    public function getActiveCategories(): mixed
    {
        return $this->query()->active()->latest();
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

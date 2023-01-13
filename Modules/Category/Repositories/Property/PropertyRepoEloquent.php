<?php

namespace Modules\Category\Repositories\Property;

use Illuminate\Database\Eloquent\Builder;
use Modules\Category\Entities\CategoryAttribute;
use Modules\Category\Entities\ProductCategory;

class PropertyRepoEloquent implements PropertyRepoEloquentInterface
{
    /**
     * Get latest categories.
     *
     * @return Builder
     */
    public function index(): Builder
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
     * Get query model (builder).
     *
     * @return Builder
     */
    private function query(): Builder
    {
        return CategoryAttribute::query();
    }
}

<?php

namespace Modules\Brand\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Modules\Brand\Entities\Brand;

class BrandRepoEloquent implements BrandRepoEloquentInterface
{
    /**
     * Get the latest roles with permissions.
     *
     * @return Builder
     */
    public function index(): Builder
    {
        return $this->query()->latest();
    }

    // **************** home

    /**
     * @return Builder
     */
    public function getActiveBrands(): Builder
    {
        return $this->query()->active()->latest();
    }

    /**
     * @param $name
     * @param int $status
     * @return Model|Builder|null
     */
    public function search($name, int $status = Brand::STATUS_ACTIVE): Model|Builder|null
    {
        return $this->query()->where([
            ['persian_name', 'like', '%' . $name . '%'],
            ['status', $status]
        ])->orWhere([
            ['original_name','like', '%' . $name . '%'],
            ['status', $status]
        ])->orWhere([
            ['tags',  'like', '%' . $name . '%'],
            ['status', $status]
        ])->latest();
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
     * Find role by id.
     *
     * @param  $id
     * @return Builder|Builder[]|Collection|Model|null
     */
    public function findById($id): Model|Collection|Builder|array|null
    {
        return $this->query()->findOrFail($id);
    }

    /**
     * Delete role by id.
     *
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        return $this->query()->where('id', $id)->delete();
    }

    /**
     * Builder for queue model.
     *
     * @return Builder
     */
    private function query(): Builder
    {
        return Brand::query();
    }
}

<?php

namespace Modules\Banner\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
class BannerRepoEloquent implements BannerRepoEloquentInterface
{
    /**
     * Get the latest roles with permissions.
     *
     * @return Builder
     */
    public function index(): Builder
    {
        return $this->query()->with('permissions')->latest();
    }

    /**
     * Find role by id.
     *
     * @param  $id
     * @return Builder|Builder[]|Collection|Model|null
     */
    public function findById($id)
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
     * Get all permissions.
     *
     * @return Collection
     */
    public function getAllPermissions(): Collection
    {
        return Permission::all();
    }

    /**
     * Builder for queue model.
     *
     * @return Builder
     */
    private function query(): Builder
    {
        return Role::query();
    }
}

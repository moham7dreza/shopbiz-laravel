<?php

namespace Modules\ACL\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Modules\ACL\Entities\Permission;
use Modules\ACL\Entities\Role;

class RolePermissionRepoEloquent implements RolePermissionRepoEloquentInterface
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
     * @param $name
     * @return Model|Builder|null
     */
    public function searchPermission($name): Model|Builder|null
    {
        return Permission::query()->where('name', 'like', '%' . $name . '%')
            ->orWhere('description', 'like', '%' . $name . '%')->latest();
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
     * @return Builder
     */
    public function permissions(): Builder
    {
        return Permission::query()->latest();
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
     * @param $name
     * @param int $status
     * @return Model|Builder|null
     */
    public function findByName($name, int $status = Permission::STATUS_ACTIVE): Model|Builder|null
    {
        return Permission::query()->active($status)->where('name', $name)->first();
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

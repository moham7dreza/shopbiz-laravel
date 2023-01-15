<?php

namespace Modules\ACL\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Modules\ACL\Entities\Permission;
use Modules\ACL\Entities\Role;
use Modules\ACL\Repositories\RolePermissionRepoEloquent;

class RolePermissionService
{
    /**
     * Store role with assign permissions.
     *
     * @param  $request
     * @return Builder|Model
     */
    public function permissionStore($request): Model|Builder
    {
        return Permission::query()->create([
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status,
        ]);
    }

    /**
     * @param $request
     * @param $permission
     * @return mixed
     */
    public function permissionUpdate($request, $permission): mixed
    {
        return $permission->update([
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status,
        ]);
    }

    /**
     * Store role with assign permissions.
     *
     * @param  $request
     * @return mixed
     */
    public function store($request): mixed
    {
        return $this->query()->create([
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status,
        ])->permissions()->sync($request->permissions ?? []);
    }

    /**
     * Update role with sync permissions.
     *
     * @param  $request
     * @param $role
     * @return mixed
     */
    public function update($request, $role): mixed
    {
        return $role->update([
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status,
        ]);
    }

    public function rolePermissionsUpdate($request, $role)
    {
        return $role->permissions()->sync($request->permissions ?? []);
    }

    /**
     * Get query for model (builder).
     *
     * @return Builder
     */
    private function query(): Builder
    {
        return Role::query();
    }
}

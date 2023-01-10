<?php

namespace Modules\Banner\Services;

use Illuminate\Database\Eloquent\Builder;

class BannerService
{
    /**
     * Store role with assign permissions.
     *
     * @param  $request
     * @return mixed
     */
    public function store($request)
    {
        return $this->query()
            ->create(['name' => $request->name])
            ->syncPermissions($request->permissions);
    }

    /**
     * Update role with sync permissions.
     *
     * @param  $request
     * @param  $id
     * @return mixed
     */
    public function update($request, $id)
    {
        $roleRepo = new RolePermissionRepoEloquent;
        $role = $roleRepo->findById($id);

        return $role
            ->syncPermissions($request->permissions)
            ->update(['name' => $request->name]);
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

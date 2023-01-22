<?php

namespace Modules\ACL\Traits;

use Illuminate\Database\Eloquent\Concerns\HasRelationships;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\ACL\Entities\Permission;
use Modules\ACL\Entities\Role;
use Modules\ACL\Repositories\RolePermissionRepoEloquent;
use Modules\ACL\Repositories\RolePermissionRepoEloquentInterface;

trait HasPermissionTrait
{
    use HasRelationships;

    /**
     * @return BelongsToMany
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class);
    }

    /**
     * @return BelongsToMany
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * @param $permission
     * @return bool
     */
    protected function hasPermission($permission): bool
    {
        return (bool)$this->permissions->where('name', $permission->name)->count();
    }

    /**
     * @param $permission
     * @return bool
     */
    public function hasPermissionTo($permission): bool
    {
        $permissionRepo = new RolePermissionRepoEloquent();
        if (is_null($permission)) {
            return false;
        }
        if (is_array($permission)) {
            $permissionObj = $permissionRepo->findByName(get_per_name($permission));
        } else {
            $permissionObj = $permission;
        }
        return $this->hasPermission($permissionObj) || $this->hasPermissionThroughRole($permissionObj);
    }

    /**
     * @param $permission
     * @return bool
     */
    public function hasPermissionThroughRole($permission): bool
    {
        foreach ($permission->roles as $role) {
            if ($this->roles->contains($role)) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param ...$roles
     * @return bool
     */
    public function hasRole(...$roles): bool
    {
        foreach ($roles as $role) {
            if ($this->roles->contains('name', $role)) {
                return true;
            }
        }
        return false;
    }

    // old functions

    /**
     * @param $permission
     * @return bool
     */
    public function isPermission($permission): bool
    {
        return $this->permissions->contains('name', $permission->name) || $this->isRole($permission->roles);
    }

    /**
     * @param $roles
     * @return bool
     */
    public function isRole($roles): bool
    {
        return !!$roles->intersect($this->roles)->all();
    }
}

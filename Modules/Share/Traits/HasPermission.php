<?php

namespace Modules\Share\Traits;

use Illuminate\Database\Eloquent\Concerns\HasRelationships;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\ACL\Entities\Permission;
use Modules\ACL\Entities\Role;

trait HasPermission
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

    // new functions

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
        return $this->hasPermission($permission) || $this->hasPermissionThroughRole($permission);
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

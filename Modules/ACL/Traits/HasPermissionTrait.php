<?php

namespace Modules\ACL\Traits;

use Illuminate\Database\Eloquent\Concerns\HasRelationships;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\ACL\Entities\Permission;
use Modules\ACL\Entities\Role;

trait HasPermissionTrait
{
    use HasRelationships;

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class);
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    protected function hasPermission($permission): bool
    {
        return (bool) $this->permissions->where('name', $permission->name)->count();
    }

    public function hasPermissionTo($permission): bool
    {
        return $this->hasPermission($permission) || $this->hasPermissionThroughRole($permission);
    }

    public function hasPermissionThroughRole($permission): bool
    {
        foreach ($permission->roles as $role) {
            if ($this->roles->contains($role)) {
                return true;
            }
        }
        return false;
    }

    public function hasRole(...$roles): bool
    {
        foreach ($roles as $role) {
            if ($this->roles->contains('name', $role)) {
                return true;
            }
        }
        return false;
    }
}

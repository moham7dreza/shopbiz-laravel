<?php

namespace Modules\ACL\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Modules\ACL\Entities\Permission;
use Modules\User\Entities\User;

class RolePermissionPolicy
{
    use HandlesAuthorization;

    public null|Builder|Model $permission;
    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct(Permission $permission)
    {
        $this->permission = Permission::query()->where([
            ['name', Permission::PERMISSION_USER_ROLES['name']],
            ['status', 1]
        ])->first();
    }

    /**
     * Check user have permissions.
     *
     * @param  User $user
     * @return bool
     */
    public function manage(User $user): bool
    {
        if (is_null($this->permission))
            return false;
        if ($user->user_type == User::TYPE_ADMIN && $user->hasPermissionTo($this->permission))
            return true;

        return false;
    }
}

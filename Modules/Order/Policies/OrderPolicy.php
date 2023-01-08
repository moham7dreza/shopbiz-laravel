<?php

namespace Modules\Order\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\ACL\Entities\Permission;
use Modules\User\Entities\User;

class OrderPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Check user have permission.
     *
     * @param  User $user
     * @return bool
     */
    public function manage(User $user): bool
    {
        $permission = Permission::query()->where([
            ['name', Permission::PERMISSION_ORDERS['name']],
            ['status', 1]
        ])->first();
        if (is_null($permission))
            return false;
        if ($user->user_type == 1 && $user->hasPermissionTo($permission))
            return true;

        return false;
    }
}

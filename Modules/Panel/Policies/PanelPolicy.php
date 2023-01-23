<?php

namespace Modules\Panel\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\ACL\Entities\Permission;
use Modules\Share\Services\ShareService;
use Modules\User\Entities\User;

class PanelPolicy
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


    public function manage(User $user)
    {
//        if (ShareService::checkForUserHasSpecialPermissionsCount([Permission::PERMISSION_ADMIN_PANEL]) === 1)
//            return false;
        $permission = Permission::query()->where('name', Permission::PERMISSION_ADMIN_PANEL)->first();dd($permission);
        return $user->hasPermissionTo($permission) || $user->hasAnyRole($permission->roles);
    }
}

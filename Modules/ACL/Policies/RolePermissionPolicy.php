<?php

namespace Modules\ACL\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Modules\ACL\Entities\Permission;
use Modules\Share\Services\ShareService;
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

    }

    /**
     * Check user have permissions.
     *
     * @param  User $user
     * @return bool
     */
    public function manage(User $user): bool
    {
       if (ShareService::checkForUserHasSpecialPermissionsCount([
           Permission::PERMISSION_ADMIN_PANEL,
           Permission::PERMISSION_USER_ROLES,
           Permission::PERMISSION_USER_ROLE_PERMISSIONS
       ]) === 3) {
           return true;
       }

        return false;
    }
}

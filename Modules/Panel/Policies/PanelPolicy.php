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

    /**
     * Check user have permission.
     *
     * @param User $user
     * @return bool
     */
    public function manage(User $user): bool
    {
//        if (ShareService::checkForUserHasSpecialPermissionsCount([Permission::PERMISSION_ADMIN_PANEL]) === 1)
//            return false;
        return true;
    }
}

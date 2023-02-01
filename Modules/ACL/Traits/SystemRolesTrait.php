<?php

namespace Modules\ACL\Traits;

trait SystemRolesTrait
{
    // access everywhere
    //******************************************************************************************************************
//    public const ROLE_SUPER_ADMIN = ['name' => 'role-super-admin', 'description' => 'مدیر ارشد سیستم - دسترسی نامحدود'];
    public const ROLE_SUPER_ADMIN = 'role super admin';

    /**
     * @var array|array[]
     */
    public static array $roles = [ self::ROLE_SUPER_ADMIN ];
}

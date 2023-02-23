<?php

namespace Modules\ACL\Traits;

trait RoleRoutesTrait
{
    public const ROUTE_INDEX = 'role.index';
    public const ROUTE_CREATE = 'role.create';
    public const ROUTE_STORE = 'role.store';
    public const ROUTE_EDIT = 'role.edit';
    public const ROUTE_UPDATE = 'role.update';
    public const ROUTE_DELETE = 'role.destroy';
    public const ROUTE_STATUS = 'role.status';
    public const ROUTE_PERMISSIONS_FORM = 'role.permission-form';
    public const ROUTE_PERMISSIONS_UPDATE = 'role.permission-update';
}

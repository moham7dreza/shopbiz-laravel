<?php

namespace Modules\ACL\Enums;

enum PermissionRoutesEnum: string
{
    case index = 'permission.index';
    case create = 'permission.create';
    case store = 'permission.store';
    case edit = 'permission.edit';
    case update = 'permission.update';
    case destroy = 'permission.destroy';
    case status = 'permission.status';
}

<?php

namespace Modules\ACL\Enums;

enum PermissionStatusEnum: int
{
    case STATUS_ACTIVE = 1;

    case STATUS_INACTIVE = 8;
}

<?php

namespace Modules\ACL\Enums;

enum ACLStatusEnum: int
{
    case STATUS_ACTIVE = 1;
    case STATUS_INACTIVE = 0;
}

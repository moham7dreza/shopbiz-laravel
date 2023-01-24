<?php

namespace Modules\Post\Enums;

enum PostStatusEnum:int
{
    case STATUS_ACTIVE = 1;
    case STATUS_PENDING = 2;
    case STATUS_INACTIVE = 0;
}

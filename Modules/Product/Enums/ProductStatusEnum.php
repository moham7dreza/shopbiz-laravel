<?php

namespace Modules\Product\Enums;

enum ProductStatusEnum:int
{
    case STATUS_ACTIVE = 1;
    case STATUS_PENDING = 2;
    case STATUS_INACTIVE = 0;
}

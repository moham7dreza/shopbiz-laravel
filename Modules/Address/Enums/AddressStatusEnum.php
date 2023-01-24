<?php

namespace Modules\Address\Enums;

enum AddressStatusEnum: int
{
    case STATUS_ACTIVE = 1;
    case STATUS_INACTIVE = 0;
}

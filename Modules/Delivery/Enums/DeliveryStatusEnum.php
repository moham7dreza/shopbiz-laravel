<?php

namespace Modules\Delivery\Enums;

enum DeliveryStatusEnum:int
{
    case STATUS_ACTIVE = 1;
    case STATUS_INACTIVE = 0;
}

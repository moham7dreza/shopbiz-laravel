<?php

namespace Modules\Order\Enums;

enum OrderStatusEnum:int
{
    case ORDER_STATUS_AWAIT_CONFIRM = 1;
    case ORDER_STATUS_NOT_CONFIRMED = 2;
    case ORDER_STATUS_CONFIRMED = 3;
    case ORDER_STATUS_CANCELED = 4;
    case ORDER_STATUS_RETURNED = 5;
    case ORDER_STATUS_NOT_CHECKED = 0;
}

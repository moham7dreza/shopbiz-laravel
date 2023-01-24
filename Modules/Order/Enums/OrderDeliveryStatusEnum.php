<?php

namespace Modules\Order\Enums;

enum OrderDeliveryStatusEnum:int
{
    case DELIVERY_STATUS_NOT_SEND = 0;
    case DELIVERY_STATUS_SENDING = 1;
    case DELIVERY_STATUS_SEND = 2;
    case DELIVERY_STATUS_DELIVERED = 3;
}

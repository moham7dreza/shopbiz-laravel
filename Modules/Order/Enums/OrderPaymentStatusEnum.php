<?php

namespace Modules\Order\Enums;

enum OrderPaymentStatusEnum:int
{
    case PAYMENT_STATUS_NOT_PAID = 0;
    case PAYMENT_STATUS_PAID = 1;
    case PAYMENT_STATUS_CANCELED = 2;
    case PAYMENT_STATUS_RETURNED = 3;
}

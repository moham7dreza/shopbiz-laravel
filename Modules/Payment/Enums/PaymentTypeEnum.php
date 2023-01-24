<?php

namespace Modules\Payment\Enums;

enum PaymentTypeEnum:int
{
    case PAYMENT_TYPE_ONLINE = 0;
    case PAYMENT_TYPE_OFFLINE = 1;
    case PAYMENT_TYPE_CASH = 2;
}

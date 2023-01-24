<?php

namespace Modules\Auth\Enums;

enum OtpStatusEnum: int
{
    case STATUS_ACTIVE = 1;
    case STATUS_INACTIVE = 0;
}

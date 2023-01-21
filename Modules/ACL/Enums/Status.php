<?php

namespace Modules\ACL\Enums;

use Illuminate\Validation\Rules\Enum;

final class Status extends Enum
{
    const STATUS_ACTIVE = 1;
    const STATUS_IN_ACTIVE = 0;
}

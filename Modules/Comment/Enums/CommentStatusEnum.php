<?php

namespace Modules\Comment\Enums;

enum CommentStatusEnum:int
{
    case STATUS_ACTIVE = 1;
    case STATUS_INACTIVE = 0;
    case STATUS_NEW = 2;
}

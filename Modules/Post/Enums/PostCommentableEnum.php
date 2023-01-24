<?php

namespace Modules\Post\Enums;

enum PostCommentableEnum:int
{

    case IS_COMMENTABLE = 1;
    case IS_NOT_COMMENTABLE = 0;
}

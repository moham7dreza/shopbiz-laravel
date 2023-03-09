<?php

namespace Modules\Notify\Services\Chat;

use Illuminate\Database\Eloquent\Builder;
use Modules\Notify\Entities\Chat;

class ChatService implements ChatServiceInterface
{
    /**
     * @return Builder
     */
    private function query(): Builder
    {
        return Chat::query();
    }
}

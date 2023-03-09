<?php

namespace Modules\Notify\Repositories\ChatAdmin;

use Illuminate\Database\Eloquent\Builder;
use Modules\Notify\Entities\ChatAdmin;

class ChatAdminRepoEloquent implements ChatAdminRepoEloquentInterface
{
    /**
     * @return Builder
     */
    private function query(): Builder
    {
        return ChatAdmin::query();
    }
}

<?php

namespace Modules\Notify\Services\ChatAdmin;

use Illuminate\Database\Eloquent\Builder;
use Modules\Notify\Entities\ChatAdmin;

class ChatAdminService implements ChatAdminServiceInterface
{
    /**
     * @param $admin
     * @return void
     */
    public function addOrRemoveFromChatAdmin($admin): void
    {
        $this->query()->where('user_id', $admin->id)->first()
            ? $this->query()->where(['user_id' => $admin->id])->forceDelete()
            : $this->query()->create(['user_id' => $admin->id]);
    }

    /**
     * @return Builder
     */
    private function query(): Builder
    {
        return ChatAdmin::query();
    }
}

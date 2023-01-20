<?php

namespace Modules\Ticket\Services\TicketAdmin;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ticket\Entities\TicketAdmin;

class TicketAdminService implements TicketAdminServiceInterface
{
    /**
     * @param $admin
     * @return void
     */
    public function addOrRemoveFromTicketAdmin($admin): void
    {
        $this->query()->where('user_id', $admin->id)->first()
            ? $this->query()->where(['user_id' => $admin->id])->forceDelete()
            : $this->query()->create(['user_id' => $admin->id]);
    }

    /**
     * Get product query (builder).
     *
     * @return Builder
     */
    private function query(): Builder
    {
        return TicketAdmin::query();
    }
}

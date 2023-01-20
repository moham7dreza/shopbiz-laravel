<?php

namespace Modules\Notify\Services\Notification;

use Illuminate\Database\Eloquent\Builder;
use Modules\Notify\Entities\Notification;

class NotificationService implements NotificationServiceInterface
{
    /**
     * @param $notifications
     * @return void
     */
    public function readAllNotifications($notifications): void
    {
        foreach ($notifications as $notification) {
            $notification->update(['read_at' => now()]);
        }
    }

    /**
     * Get product query (builder).
     *
     * @return Builder
     */
    private function query(): Builder
    {
        return Notification::query();
    }
}

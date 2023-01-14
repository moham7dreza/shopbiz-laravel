<?php

namespace Modules\Notify\Http\Controllers;


use Modules\Notify\Entities\Notification;
use Modules\Notify\Repositories\Notification\NotificationRepoEloquentInterface;
use Modules\Notify\Services\Notification\NotificationService;
use Modules\Share\Http\Controllers\Controller;

class NotificationController extends Controller
{
    /**
     * @var string
     */
    private string $class = Notification::class;

    public NotificationRepoEloquentInterface $repo;
    public NotificationService $service;

    /**
     * @param NotificationRepoEloquentInterface $faqRepoEloquent
     * @param NotificationService $faqService
     */
    public function __construct(NotificationRepoEloquentInterface $faqRepoEloquent, NotificationService $faqService)
    {
        $this->repo = $faqRepoEloquent;
        $this->service = $faqService;
    }

    /**
     * @return void
     */
    public function readAll(): void
    {
        $notifications = $this->repo->all();
        foreach ($notifications as $notification) {
            $notification->update(['read_at' => now()]);
        }
    }
}

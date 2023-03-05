<?php

namespace Modules\Notify\Http\Controllers\Api;

use Modules\Notify\Entities\Notification;
use Modules\Notify\Http\Resources\NotificationResource;
use Modules\Notify\Repositories\Notification\NotificationRepoEloquentInterface;
use Modules\Notify\Services\Notification\NotificationService;
use Modules\Share\Http\Controllers\Controller;

class ApiNotificationController extends Controller
{
    public NotificationRepoEloquentInterface $repo;
    public NotificationService $service;

    /**
     * @param NotificationRepoEloquentInterface $repo
     * @param NotificationService $service
     */
    public function __construct(NotificationRepoEloquentInterface $repo, NotificationService $service)
    {
        $this->repo = $repo;
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return NotificationResource
     */
    public function index(): NotificationResource
    {
        $unreadNotifications = Notification::where('read_at', null)->get();
        return new NotificationResource($unreadNotifications);
    }
}

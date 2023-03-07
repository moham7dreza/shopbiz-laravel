<?php

namespace Modules\Notify\Http\Controllers\Api;

use Modules\Notify\Entities\Notification;
use Modules\Notify\Http\Resources\NotificationResource;
use Modules\Notify\Repositories\Notification\NotificationRepoEloquentInterface;
use Modules\Notify\Services\Notification\NotificationService;
use Modules\Share\Http\Controllers\Controller;
use Modules\User\Entities\User;
use Modules\User\Repositories\UserRepoEloquentInterface;

class ApiNotificationController extends Controller
{
    public UserRepoEloquentInterface $userRepoEloquent;
    public NotificationRepoEloquentInterface $repo;
    public NotificationService $service;

    /**
     * @param NotificationRepoEloquentInterface $repo
     * @param NotificationService $service
     * @param UserRepoEloquentInterface $userRepoEloquent
     */
    public function __construct(NotificationRepoEloquentInterface $repo, NotificationService $service, UserRepoEloquentInterface $userRepoEloquent)
    {
        $this->repo = $repo;
        $this->service = $service;
        $this->userRepoEloquent = $userRepoEloquent;
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

    /**
     * @param User $user
     * @return NotificationResource
     */
    public function findUserNotifications(User $user): NotificationResource
    {
        $notifs = $user->notifications()->latest()->get();
        return new NotificationResource($notifs);
    }
}

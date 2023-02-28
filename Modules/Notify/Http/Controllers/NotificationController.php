<?php

namespace Modules\Notify\Http\Controllers;


use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Modules\Notify\Entities\Notification;
use Modules\Notify\Repositories\Notification\NotificationRepoEloquentInterface;
use Modules\Notify\Services\Notification\NotificationService;
use Modules\Share\Http\Controllers\Controller;
use Modules\Share\Services\ShareService;
use Modules\Share\Traits\ShowMessageWithRedirectTrait;

class NotificationController extends Controller
{
    use ShowMessageWithRedirectTrait;

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
     * @return mixed
     */
    public function readAll(): mixed
    {
        return auth()->user()->notifications()->get()->toQuery()->update(['read_at' => now()]);
    }

    /**
     * @return Application|Factory|View|RedirectResponse
     */
    public function userNotifs(): View|Factory|Application|RedirectResponse
    {
        $query = auth()->user()->notifications()->whereNull('read_at');
        if ($query->count() < 1) {
            return $this->showAlertWithRedirect(message: 'شما اعلان جدیدی ندارید', title: 'هشدار', type: 'warning');
        }
        $notifications = $query->latest()->get();
        $this->readAll();
        return view('Notify::home.user-notifications', compact('notifications'));
    }
}

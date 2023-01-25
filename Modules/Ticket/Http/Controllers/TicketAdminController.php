<?php

namespace Modules\Ticket\Http\Controllers;


use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Modules\Share\Http\Controllers\Controller;
use Modules\Share\Traits\ShowMessageWithRedirectTrait;
use Modules\Ticket\Entities\TicketAdmin;
use Modules\Ticket\Repositories\TicketAdmin\TicketAdminRepoEloquentInterface;
use Modules\Ticket\Services\TicketAdmin\TicketAdminService;
use Modules\User\Entities\User;
use Modules\User\Repositories\UserRepoEloquentInterface;

class TicketAdminController extends Controller
{
    use ShowMessageWithRedirectTrait;
    /**
     * @var string
     */
    private string $redirectRoute = 'ticket-admin.index';

    /**
     * @var string
     */
    private string $class = TicketAdmin::class;

    public TicketAdminRepoEloquentInterface $repo;
    public TicketAdminService $service;

    /**
     * @param TicketAdminRepoEloquentInterface $ticketRepoEloquent
     * @param TicketAdminService $ticketService
     */
    public function __construct(TicketAdminRepoEloquentInterface $ticketRepoEloquent, TicketAdminService $ticketService)
    {
        $this->repo = $ticketRepoEloquent;
        $this->service = $ticketService;

        $this->middleware('can:permission-admin-tickets')->only(['index']);
        $this->middleware('can:permission-admin-ticket-add')->only(['set']);
    }

    /**
     * @param UserRepoEloquentInterface $userRepo
     * @return Application|Factory|View
     */
    public function index(UserRepoEloquentInterface $userRepo): View|Factory|Application
    {
        $admins = $userRepo->adminUsers()->paginate(10);
        return view('Ticket::admin.index', compact(['admins']));
    }


    /**
     * @param User $admin
     * @return RedirectResponse
     */
    public function set(User $admin): RedirectResponse
    {
        $this->service->addOrRemoveFromTicketAdmin($admin);
        return $this->showMessageWithRedirect('تغییر شما با موفقیت حذف شد');
    }
}

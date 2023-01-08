<?php

namespace Modules\Ticket\Http\Controllers;


use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Modules\Share\Http\Controllers\Controller;
use Modules\Ticket\Entities\TicketAdmin;
use Modules\Ticket\Repositories\TicketAdmin\TicketAdminRepoEloquentInterface;
use Modules\Ticket\Services\TicketAdmin\TicketAdminService;
use Modules\User\Entities\User;

class TicketAdminController extends Controller
{

    private string $redirectRoute = 'ticket-admin.index';

    private string $class = TicketAdmin::class;

    public TicketAdminRepoEloquentInterface $repo;
    public TicketAdminService $service;

    public function __construct(TicketAdminRepoEloquentInterface $ticketRepoEloquent, TicketAdminService $ticketService)
    {
        $this->repo = $ticketRepoEloquent;
        $this->service = $ticketService;

        $this->middleware('can:permission-admin-tickets')->only(['index']);
        $this->middleware('can:permission-admin-ticket-add')->only(['set']);
    }
    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $admins = User::query()->where('user_type', 1)->get();
        return view('Ticket::admin.index', compact('admins'));
    }


    /**
     * @param User $admin
     * @return RedirectResponse
     */
    public function set(User $admin): RedirectResponse
    {
        TicketAdmin::query()->where('user_id', $admin->id)->first()
            ? TicketAdmin::query()->where(['user_id' => $admin->id])->forceDelete()
            : TicketAdmin::query()->create(['user_id' => $admin->id]);
        return redirect()->route('ticket-admin.index')->with('swal-success', 'تغییر شما با موفقیت حذف شد');
    }
}

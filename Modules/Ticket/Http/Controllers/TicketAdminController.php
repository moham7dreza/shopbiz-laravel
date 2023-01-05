<?php

namespace Modules\Ticket\Http\Controllers;


use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Modules\Share\Http\Controllers\Controller;
use Modules\Ticket\Entities\TicketAdmin;
use Modules\User\Entities\User;

class TicketAdminController extends Controller
{
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
    public function set(User $admin)
    {
        TicketAdmin::query()->where('user_id', $admin->id)->first()
            ? TicketAdmin::query()->where(['user_id' => $admin->id])->forceDelete()
            : TicketAdmin::query()->create(['user_id' => $admin->id]);
        return redirect()->route('admin.ticket.admin.index')->with('swal-success', 'تغییر شما با موفقیت حذف شد');
    }
}

<?php

namespace Modules\User\Http\Controllers\Home\Profile;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Modules\Share\Http\Controllers\Controller;
use Modules\Share\Traits\ShowMessageWithRedirectTrait;
use Modules\Ticket\Entities\Ticket;
use Modules\Ticket\Services\Ticket\TicketServiceInterface;
use Modules\User\Http\Requests\Home\StoreTicketRequest;

class ProfileTicketController extends Controller
{
    use ShowMessageWithRedirectTrait;

    public TicketServiceInterface $ticketService;

    /**
     * @param TicketServiceInterface $ticketService
     */
    public function __construct(TicketServiceInterface $ticketService)
    {
        $this->ticketService = $ticketService;
    }

    /**
     * @return Application|Factory|View
     */
    public function index(): View|Factory|Application
    {
        $tickets = auth()->user()->tickets;

        return view('User::home.profile.ticket.index', compact('tickets'));
    }

    /**
     * @param Ticket $ticket
     * @return Factory|View|Application
     */
    public function show(Ticket $ticket): Factory|View|Application
    {
        return view('User::home.profile.ticket.show', compact('ticket'));
    }

    /**
     * @param StoreTicketRequest $request
     * @param Ticket $ticket
     * @return RedirectResponse
     */
    public function answer(StoreTicketRequest $request, Ticket $ticket): RedirectResponse
    {
        $this->ticketService->store($request, $ticket, 'user');
        return $this->showAlertWithRedirect('پاسخ شما با موفقیت ثبت شد');
    }


    /**
     * @param Ticket $ticket
     * @return RedirectResponse
     */
    public function change(Ticket $ticket): RedirectResponse
    {
        $this->ticketService->changeTicketStatus($ticket);
        return $this->showAlertWithRedirect('تغییر شما با موفقیت ثبت شد');
    }

}

<?php

namespace Modules\Ticket\Http\Controllers;


use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Modules\Share\Http\Controllers\Controller;
use Modules\Ticket\Entities\Ticket;
use Modules\Ticket\Http\Requests\TicketRequest;
use Modules\Ticket\Repositories\Ticket\TicketRepoEloquentInterface;
use Modules\Ticket\Services\Ticket\TicketService;

class TicketController extends Controller
{
    private string $redirectRoute = 'ticket.index';

    private string $class = Ticket::class;

    public TicketRepoEloquentInterface $repo;
    public TicketService $service;

    /**
     * @param TicketRepoEloquentInterface $ticketRepoEloquent
     * @param TicketService $ticketService
     */
    public function __construct(TicketRepoEloquentInterface $ticketRepoEloquent, TicketService $ticketService)
    {
        $this->repo = $ticketRepoEloquent;
        $this->service = $ticketService;

        $this->middleware('can:permission-all-tickets')->only(['index']);
        $this->middleware('can:permission-new-tickets')->only(['newTickets']);
        $this->middleware('can:permission-close-tickets')->only(['closeTickets']);
        $this->middleware('can:permission-open-tickets')->only(['openTickets']);
        $this->middleware('can:permission-all-ticket-show')->only(['show']);
        $this->middleware('can:permission-all-ticket-change')->only(['change']);
    }
    /**
     * @return Application|Factory|View
     */
    public function newTickets(): View|Factory|Application
    {
        $tickets = $this->repo->newTickets()->paginate(10);
        foreach ($tickets as $newTicket) {
            $newTicket->seen = 1;
            $result = $newTicket->save();
        }
        return view('Ticket::index', compact('tickets'));
    }

    /**
     * @return Application|Factory|View
     */
    public function openTickets(): View|Factory|Application
    {
        $tickets = $this->repo->openTickets()->paginate(10);
        return view('Ticket::index', compact('tickets'));
    }

    /**
     * @return Factory|View|Application
     */
    public function closeTickets(): Factory|View|Application
    {
        $tickets = $this->repo->closeTickets()->paginate(10);
        return view('Ticket::index', compact('tickets'));
    }

    /**
     * @return Application|Factory|View
     */
    public function index(): View|Factory|Application
    {
        $tickets = $this->repo->index()->paginate(10);
        return view('Ticket::index', compact('tickets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort(403);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        abort(403);
    }

    /**
     * Display the specified resource.
     *
     * @param Ticket $ticket
     * @return Application|Factory|View
     */
    public function show(Ticket $ticket): View|Factory|Application
    {
        return view('Ticket::show', compact('ticket'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort(403);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        abort(403);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort(403);
    }


    /**
     * @param TicketRequest $request
     * @param Ticket $ticket
     * @return RedirectResponse
     */
    public function answer(TicketRequest $request, Ticket $ticket): RedirectResponse
    {

        $inputs = $request->all();
        $inputs['subject'] = $ticket->subject;
        $inputs['description'] = $request->description;
        $inputs['seen'] = 1;
        $inputs['reference_id'] = $ticket->reference_id;
        $inputs['user_id'] = 1;
        $inputs['category_id'] = $ticket->category_id;
        $inputs['priority_id'] = $ticket->priority_id;
        $inputs['ticket_id'] = $ticket->id;
        $ticket = Ticket::query()->create($inputs);
        return redirect()->route('ticket.index')->with('swal-success', '  پاسخ شما با موفقیت ثبت شد');
    }


    /**
     * @param Ticket $ticket
     * @return RedirectResponse
     */
    public function change(Ticket $ticket): RedirectResponse
    {
        $ticket->status = $ticket->status == 0 ? 1 : 0;
        $result = $ticket->save();
        return redirect()->route('ticket.index')->with('swal-success', 'تغییر شما با موفقیت حذف شد');
    }
}

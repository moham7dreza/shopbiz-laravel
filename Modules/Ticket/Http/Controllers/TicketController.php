<?php

namespace Modules\Ticket\Http\Controllers;


use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Modules\ACL\Entities\Permission;
use Modules\Share\Http\Controllers\Controller;
use Modules\Share\Traits\ShowMessageWithRedirectTrait;
use Modules\Ticket\Entities\Ticket;
use Modules\Ticket\Http\Requests\TicketRequest;
use Modules\Ticket\Repositories\Ticket\TicketRepoEloquentInterface;
use Modules\Ticket\Services\Ticket\TicketService;

class TicketController extends Controller
{
    use ShowMessageWithRedirectTrait;

    /**
     * @var string
     */
    private string $redirectRoute = 'ticket.index';

    /**
     * @var string
     */
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

        $this->middleware('can:' . Permission::PERMISSION_ALL_TICKETS)->only(['index']);
        $this->middleware('can:' . Permission::PERMISSION_NEW_TICKETS)->only(['newTickets']);
        $this->middleware('can:' . Permission::PERMISSION_CLOSE_TICKETS)->only(['closeTickets']);
        $this->middleware('can:' . Permission::PERMISSION_OPEN_TICKETS)->only(['openTickets']);
        $this->middleware('can:' . Permission::PERMISSION_TICKET_SHOW)->only(['show']);
        $this->middleware('can:' . Permission::PERMISSION_TICKET_CHANGE)->only(['change']);
    }

    /**
     * @return Application|Factory|View|RedirectResponse
     */
    public function newTickets(): View|Factory|Application|RedirectResponse
    {
        $route = 'ticket.newTickets';
        $title = 'تیکت های جدید';
        $tickets = $this->checkForRequestsAndMakeQuery('newTickets');
        if ($tickets == 'not result found') {
            return $this->showAlertOfNotResultFound($route);
        }
        $this->service->makeSeenTickets($tickets);
        return view('Ticket::index', compact(['tickets', 'route', 'title']));
    }

    /**
     * @return Application|Factory|View|RedirectResponse
     */
    public function openTickets(): View|Factory|Application|RedirectResponse
    {
        $route = 'ticket.openTickets';
        $title = 'تیکت های باز';
        $tickets = $this->checkForRequestsAndMakeQuery('openTickets');
        if ($tickets == 'not result found') {
            return $this->showAlertOfNotResultFound($route);
        }
        return view('Ticket::index', compact(['tickets', 'route', 'title']));
    }

    /**
     * @return Factory|View|Application|RedirectResponse
     */
    public function closeTickets(): Factory|View|Application|RedirectResponse
    {
        $route = 'ticket.closeTickets';
        $title = 'تیکت های بسته';
        $tickets = $this->checkForRequestsAndMakeQuery('closeTickets');
        if ($tickets == 'not result found') {
            return $this->showAlertOfNotResultFound($route);
        }
        return view('Ticket::index', compact(['tickets', 'route', 'title']));
    }

    /**
     * @return Application|Factory|View|RedirectResponse
     */
    public function index(): View|Factory|Application|RedirectResponse
    {
        $route = 'ticket.index';
        $title = 'همه تیکت ها';
        $tickets = $this->checkForRequestsAndMakeQuery('all');
        if ($tickets == 'not result found') {
            return $this->showAlertOfNotResultFound($route);
        }
        return view('Ticket::index', compact(['tickets', 'route', 'title']));
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
        return view('Ticket::show', compact(['ticket']));
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
        $this->service->store($request, $ticket);
        return $this->showMessageWithRedirectRoute('پاسخ شما با موفقیت ثبت شد');
    }


    /**
     * @param Ticket $ticket
     * @return RedirectResponse
     */
    public function change(Ticket $ticket): RedirectResponse
    {
        $this->service->changeTicketStatus($ticket);
        return $this->showMessageWithRedirectRoute('تغییر شما با موفقیت ثبت شد');
    }

    /**
     * @param $ticketType
     * @return LengthAwarePaginator|string
     */
    private function checkForRequestsAndMakeQuery($ticketType): LengthAwarePaginator|string
    {
        if (isset(request()->search)) {
            $tickets = $this->repo->search(request()->search, $ticketType)->paginate(10);
            if (count($tickets) > 0) {
                $this->showToastOfFetchedRecordsCount(count($tickets));
            } else {
                return 'not result found';
            }
        } elseif (isset(request()->sort)) {
            $tickets = $this->repo->sort(request()->sort, request()->dir, $ticketType)->paginate(10);
            if (count($tickets) > 0) {
                $this->showToastOfSelectedDirection(request()->dir);
            }
            else { $this->showToastOfNotDataExists(); }
        } else {
            $ticketType = $ticketType == 'all' ? 'index' : $ticketType;
            $tickets = $this->repo->$ticketType()->paginate(10);
        }
        return $tickets;
    }
}

<?php

namespace Modules\Ticket\Http\Controllers;


use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Modules\Share\Http\Controllers\Controller;
use Modules\Ticket\Entities\Ticket;
use Modules\Ticket\Http\Requests\TicketRequest;

class TicketController extends Controller
{

    /**
     * @return Application|Factory|View
     */
    public function newTickets()
    {
        $tickets = Ticket::query()->where('seen', 0)->get();
        foreach ($tickets as $newTicket) {
            $newTicket->seen = 1;
            $result = $newTicket->save();
        }
        return view('Ticket::index', compact('tickets'));
    }

    /**
     * @return Application|Factory|View
     */
    public function openTickets()
    {
        $tickets = Ticket::query()->where('status', 0)->get();
        return view('Ticket::index', compact('tickets'));
    }

    public function closeTickets()
    {
        $tickets = Ticket::query()->where('status', 1)->get();
        return view('Ticket::index', compact('tickets'));
    }

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $tickets = Ticket::all();
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
    public function show(Ticket $ticket)
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

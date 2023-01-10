<?php

namespace Modules\Ticket\Http\Controllers;


use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Modules\Share\Http\Controllers\Controller;
use Modules\Ticket\Entities\TicketPriority;
use Modules\Ticket\Http\Requests\TicketPriorityRequest;
use Modules\Ticket\Repositories\TicketPriority\TicketPriorityRepoEloquentInterface;
use Modules\Ticket\Services\TicketPriority\TicketPriorityService;

class TicketPriorityController extends Controller
{

    private string $redirectRoute = 'ticket-priority.index';

    private string $class = TicketPriority::class;

    public TicketPriorityRepoEloquentInterface $repo;
    public TicketPriorityService $service;

    public function __construct(TicketPriorityRepoEloquentInterface $ticketRepoEloquent, TicketPriorityService $ticketService)
    {
        $this->repo = $ticketRepoEloquent;
        $this->service = $ticketService;

        $this->middleware('can:permission-ticket-priorities')->only(['index']);
        $this->middleware('can:permission-ticket-priority-create')->only(['create', 'store']);
        $this->middleware('can:permission-ticket-priority-edit')->only(['edit', 'update']);
        $this->middleware('can:permission-ticket-priority-delete')->only(['destroy']);
        $this->middleware('can:permission-ticket-priority-status')->only(['status']);
    }
    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $ticketPriorities = TicketPriority::all();
        return view('Ticket::priority.index', compact('ticketPriorities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('Ticket::priority.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TicketPriorityRequest $request
     * @return RedirectResponse
     */
    public function store(TicketPriorityRequest $request): RedirectResponse
    {
        $inputs = $request->all();
        $ticketPriority = TicketPriority::query()->create($inputs);
        return redirect()->route('ticket-priority.index')->with('swal-success', 'اولویت  جدید شما با موفقیت ثبت شد');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort(403);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param TicketPriority $ticketPriority
     * @return Application|Factory|View
     */
    public function edit(TicketPriority $ticketPriority)
    {
        return view('Ticket::priority.edit', compact('ticketPriority'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param TicketPriorityRequest $request
     * @param TicketPriority $ticketPriority
     * @return RedirectResponse
     */
    public function update(TicketPriorityRequest $request, TicketPriority $ticketPriority): RedirectResponse
    {
        $inputs = $request->all();
        $ticketPriority->update($inputs);
        return redirect()->route('ticket-priority.index')->with('swal-success', 'اولویت شما با موفقیت ویرایش شد');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param TicketPriority $ticketPriority
     * @return RedirectResponse
     */
    public function destroy(TicketPriority $ticketPriority)
    {
        $result = $ticketPriority->delete();
        return redirect()->route('ticket-priority.index')->with('swal-success', 'اولویت شما با موفقیت حذف شد');
    }


    /**
     * @param TicketPriority $ticketPriority
     * @return JsonResponse
     */
    public function status(TicketPriority $ticketPriority): JsonResponse
    {
        $ticketPriority->status = $ticketPriority->status == 0 ? 1 : 0;
        $result = $ticketPriority->save();
        if ($result) {
            if ($ticketPriority->status == 0) {
                return response()->json(['status' => true, 'checked' => false]);
            } else {
                return response()->json(['status' => true, 'checked' => true]);
            }
        } else {
            return response()->json(['status' => false]);
        }
    }
}

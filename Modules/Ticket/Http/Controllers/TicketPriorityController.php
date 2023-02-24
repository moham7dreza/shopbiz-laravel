<?php

namespace Modules\Ticket\Http\Controllers;


use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Modules\ACL\Entities\Permission;
use Modules\Share\Http\Controllers\Controller;
use Modules\Share\Services\ShareService;
use Modules\Share\Traits\ShowMessageWithRedirectTrait;
use Modules\Ticket\Entities\TicketPriority;
use Modules\Ticket\Http\Requests\TicketPriorityRequest;
use Modules\Ticket\Repositories\TicketPriority\TicketPriorityRepoEloquentInterface;
use Modules\Ticket\Services\TicketPriority\TicketPriorityService;

class TicketPriorityController extends Controller
{
    use ShowMessageWithRedirectTrait;
    /**
     * @var string
     */
    private string $redirectRoute = 'ticketPriority.index';

    /**
     * @var string
     */
    private string $class = TicketPriority::class;

    public TicketPriorityRepoEloquentInterface $repo;
    public TicketPriorityService $service;

    /**
     * @param TicketPriorityRepoEloquentInterface $ticketRepoEloquent
     * @param TicketPriorityService $ticketService
     */
    public function __construct(TicketPriorityRepoEloquentInterface $ticketRepoEloquent, TicketPriorityService $ticketService)
    {
        $this->repo = $ticketRepoEloquent;
        $this->service = $ticketService;

        $this->middleware('can:' . Permission::PERMISSION_TICKET_PRIORITIES)->only(['index']);
        $this->middleware('can:' . Permission::PERMISSION_TICKET_PRIORITY_CREATE)->only(['create', 'store']);
        $this->middleware('can:' . Permission::PERMISSION_TICKET_PRIORITY_EDIT)->only(['edit', 'update']);
        $this->middleware('can:' . Permission::PERMISSION_TICKET_PRIORITY_DELETE)->only(['destroy']);
        $this->middleware('can:' . Permission::PERMISSION_TICKET_PRIORITY_STATUS)->only(['status']);
    }

    /**
     * @return Application|Factory|View|RedirectResponse
     */
    public function index(): View|Factory|Application|RedirectResponse
    {
        if (isset(request()->search)) {
            $ticketPriorities = $this->repo->search(request()->search)->paginate(10);
            if (count($ticketPriorities) > 0) {
                $this->showToastOfFetchedRecordsCount(count($ticketPriorities));
            } else {
                return $this->showAlertOfNotResultFound();
            }
        } elseif (isset(request()->sort)) {
            $ticketPriorities = $this->repo->sort(request()->sort, request()->dir)->paginate(10);
            if (count($ticketPriorities) > 0) {
                $this->showToastOfSelectedDirection(request()->dir);
            }
            else { $this->showToastOfNotDataExists(); }
        } else {
            $ticketPriorities = $this->repo->index()->paginate(10);
        }

        return view('Ticket::priority.index', compact(['ticketPriorities']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(): View|Factory|Application
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
        $this->service->store($request);
        return $this->showMessageWithRedirectRoute('اولویت  جدید شما با موفقیت ثبت شد');
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
    public function edit(TicketPriority $ticketPriority): View|Factory|Application
    {
        return view('Ticket::priority.edit', compact(['ticketPriority']));

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
        $this->service->update($request, $ticketPriority);
        return $this->showMessageWithRedirectRoute('اولویت شما با موفقیت ویرایش شد');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param TicketPriority $ticketPriority
     * @return RedirectResponse
     */
    public function destroy(TicketPriority $ticketPriority): RedirectResponse
    {
        $result = $ticketPriority->delete();
        return $this->showMessageWithRedirectRoute('اولویت شما با موفقیت حذف شد');
    }


    /**
     * @param TicketPriority $ticketPriority
     * @return JsonResponse
     */
    public function status(TicketPriority $ticketPriority): JsonResponse
    {
        return ShareService::changeStatus($ticketPriority);
    }
}

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
use Modules\Ticket\Entities\TicketCategory;
use Modules\Ticket\Http\Requests\TicketCategoryRequest;
use Modules\Ticket\Repositories\TicketCategory\TicketCategoryRepoEloquentInterface;
use Modules\Ticket\Services\TicketCategory\TicketCategoryService;

class TicketCategoryController extends Controller
{
    use ShowMessageWithRedirectTrait;

    /**
     * @var string
     */
    private string $redirectRoute = 'ticketCategory.index';

    /**
     * @var string
     */
    private string $class = TicketCategory::class;

    public TicketCategoryRepoEloquentInterface $repo;
    public TicketCategoryService $service;

    /**
     * @param TicketCategoryRepoEloquentInterface $ticketRepoEloquent
     * @param TicketCategoryService $ticketService
     */
    public function __construct(TicketCategoryRepoEloquentInterface $ticketRepoEloquent, TicketCategoryService $ticketService)
    {
        $this->repo = $ticketRepoEloquent;
        $this->service = $ticketService;

        $this->middleware('can:' . Permission::PERMISSION_TICKET_CATEGORIES)->only(['index']);
        $this->middleware('can:' . Permission::PERMISSION_TICKET_CATEGORY_CREATE)->only(['create', 'store']);
        $this->middleware('can:' . Permission::PERMISSION_TICKET_CATEGORY_EDIT)->only(['edit', 'update']);
        $this->middleware('can:' . Permission::PERMISSION_TICKET_CATEGORY_DELETE)->only(['destroy']);
        $this->middleware('can:' . Permission::PERMISSION_TICKET_CATEGORY_STATUS)->only(['status']);
    }

    /**
     * @return Application|Factory|View|RedirectResponse
     */
    public function index(): Factory|View|Application|RedirectResponse
    {
        if (isset(request()->search)) {
            $ticketCategories = $this->repo->search(request()->search)->paginate(10);
            if (count($ticketCategories) > 0) {
                $this->showToastOfFetchedRecordsCount(count($ticketCategories));
            } else {
                return $this->showAlertOfNotResultFound();
            }
        } else {
            $ticketCategories = $this->repo->index()->paginate(10);
        }

        return view('Ticket::category.index', compact(['ticketCategories']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(): View|Factory|Application
    {
        return view('Ticket::category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TicketCategoryRequest $request
     * @return RedirectResponse
     */
    public function store(TicketCategoryRequest $request): RedirectResponse
    {
        $this->service->store($request);
        return $this->showMessageWithRedirectRoute('دسته بندی جدید شما با موفقیت ثبت شد');
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
     * @param TicketCategory $ticketCategory
     * @return Application|Factory|View
     */
    public function edit(TicketCategory $ticketCategory): View|Factory|Application
    {
        return view('Ticket::category.edit', compact(['ticketCategory']));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param TicketCategoryRequest $request
     * @param TicketCategory $ticketCategory
     * @return RedirectResponse
     */
    public function update(TicketCategoryRequest $request, TicketCategory $ticketCategory): RedirectResponse
    {
        $this->service->update($request, $ticketCategory);
        return $this->showMessageWithRedirectRoute('دسته بندی شما با موفقیت ویرایش شد');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param TicketCategory $ticketCategory
     * @return RedirectResponse
     */
    public function destroy(TicketCategory $ticketCategory): RedirectResponse
    {
        $result = $ticketCategory->delete();
        return $this->showMessageWithRedirectRoute('دسته بندی شما با موفقیت حذف شد');
    }


    /**
     * @param TicketCategory $ticketCategory
     * @return JsonResponse
     */
    public function status(TicketCategory $ticketCategory): JsonResponse
    {
        return ShareService::changeStatus($ticketCategory);
    }
}

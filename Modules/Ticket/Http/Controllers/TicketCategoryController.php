<?php

namespace Modules\Ticket\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Modules\Share\Http\Controllers\Controller;
use Modules\Ticket\Entities\TicketCategory;
use Modules\Ticket\Http\Requests\TicketCategoryRequest;
use Modules\Ticket\Repositories\TicketCategory\TicketCategoryRepoEloquentInterface;
use Modules\Ticket\Services\TicketCategory\TicketCategoryService;

class TicketCategoryController extends Controller
{

    private string $redirectRoute = 'ticket-category.index';

    private string $class = TicketCategory::class;

    public TicketCategoryRepoEloquentInterface $repo;
    public TicketCategoryService $service;

    public function __construct(TicketCategoryRepoEloquentInterface $ticketRepoEloquent, TicketCategoryService $ticketService)
    {
        $this->repo = $ticketRepoEloquent;
        $this->service = $ticketService;

        $this->middleware('can:permission-ticket-categories')->only(['index']);
        $this->middleware('can:permission-ticket-category-create')->only(['create', 'store']);
        $this->middleware('can:permission-ticket-category-edit')->only(['edit', 'update']);
        $this->middleware('can:permission-ticket-category-delete')->only(['destroy']);
        $this->middleware('can:permission-ticket-category-status')->only(['status']);
    }
    /**
     * @return Application|Factory|View
     */
    public function index(): Factory|View|Application
    {
        $ticketCategories = $this->repo->index()->paginate(10);
        return view('Ticket::category.index', compact('ticketCategories'));
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
        $inputs = $request->all();
        $ticketCategory = TicketCategory::query()->create($inputs);
        return redirect()->route('ticketCategory.index')->with('swal-success', 'دسته بندی جدید شما با موفقیت ثبت شد');
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
    public function edit(TicketCategory $ticketCategory)
    {
        return view('Ticket::category.edit', compact('ticketCategory'));

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
        $inputs = $request->all();
        $ticketCategory->update($inputs);
        return redirect()->route('ticketCategory.index')->with('swal-success', 'دسته بندی شما با موفقیت ویرایش شد');
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
        return redirect()->route('ticketCategory.index')->with('swal-success', 'دسته بندی شما با موفقیت حذف شد');
    }


    /**
     * @param TicketCategory $ticketCategory
     * @return JsonResponse
     */
    public function status(TicketCategory $ticketCategory): JsonResponse
    {

        $ticketCategory->status = $ticketCategory->status == 0 ? 1 : 0;
        $result = $ticketCategory->save();
        if ($result) {
            if ($ticketCategory->status == 0) {
                return response()->json(['status' => true, 'checked' => false]);
            } else {
                return response()->json(['status' => true, 'checked' => true]);
            }
        } else {
            return response()->json(['status' => false]);
        }

    }
}

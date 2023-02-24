<?php

namespace Modules\Product\Http\Controllers;


use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\ACL\Entities\Permission;
use Modules\Product\Entities\Guarantee;
use Modules\Product\Entities\Product;
use Modules\Product\Http\Requests\GuaranteeRequest;
use Modules\Product\Http\Requests\ProductGuaranteeRequest;
use Modules\Product\Repositories\Guarantee\GuaranteeRepoEloquentInterface;
use Modules\Product\Services\Guarantee\GuaranteeService;
use Modules\Share\Http\Controllers\Controller;
use Modules\Share\Services\ShareService;
use Modules\Share\Traits\ShowMessageWithRedirectTrait;

class GuaranteeController extends Controller
{
    use ShowMessageWithRedirectTrait;

    /**
     * @var string
     */
    private string $redirectRoute = 'guarantee.index';

    /**
     * @var string
     */
    private string $class = Guarantee::class;

    public GuaranteeRepoEloquentInterface $repo;
    public GuaranteeService $service;

    /**
     * @param GuaranteeRepoEloquentInterface $guaranteeRepoEloquent
     * @param GuaranteeService $guaranteeService
     */
    public function __construct(GuaranteeRepoEloquentInterface $guaranteeRepoEloquent, GuaranteeService $guaranteeService)
    {
        $this->repo = $guaranteeRepoEloquent;
        $this->service = $guaranteeService;

        $this->middleware('can:' . Permission::PERMISSION_GUARANTEES)->only(['index']);
        $this->middleware('can:' . Permission::PERMISSION_GUARANTEE_CREATE)->only(['create', 'store']);
        $this->middleware('can:' . Permission::PERMISSION_GUARANTEE_EDIT)->only(['edit', 'update']);
        $this->middleware('can:' . Permission::PERMISSION_GUARANTEE_DELETE)->only(['destroy']);
        $this->middleware('can:' . Permission::PERMISSION_GUARANTEE_STATUS)->only(['status']);
    }

    /**
     * @return Application|Factory|View|RedirectResponse
     */
    public function index(): Factory|View|Application|RedirectResponse
    {
        if (isset(request()->search)) {
            $guarantees = $this->repo->search(request()->search)->paginate(10);
            if (count($guarantees) > 0) {
                $this->showToastOfFetchedRecordsCount(count($guarantees));
            } else {
                return $this->showAlertOfNotResultFound();
            }
        } elseif (isset(request()->sort)) {
            $guarantees = $this->repo->sort(request()->sort, request()->dir)->paginate(10);
            if (count($guarantees) > 0) {
                $this->showToastOfSelectedDirection(request()->dir);
            }
            else { $this->showToastOfNotDataExists(); }
        } else {
            $guarantees = $this->repo->getLatest()->paginate(10);
        }

        return view('Product::admin.guarantee.index', compact(['guarantees']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param
     * @return Application|Factory|View
     */
    public function create(): View|Factory|Application
    {
        return view('Product::admin.guarantee.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param GuaranteeRequest $request
     * @return RedirectResponse
     */
    public function store(GuaranteeRequest $request): RedirectResponse
    {
        $this->service->store($request);
        return $this->showMessageWithRedirectRoute('گارانتی شما با موفقیت ثبت شد');
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
     * @param Guarantee $guarantee
     * @return Application|Factory|View
     */
    public function edit(Guarantee $guarantee): View|Factory|Application
    {
        return view('Product::admin.guarantee.edit', compact(['guarantee']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param GuaranteeRequest $request
     * @param Guarantee $guarantee
     * @return RedirectResponse
     */
    public function update(GuaranteeRequest $request, Guarantee $guarantee): RedirectResponse
    {
        $this->service->update($request,$guarantee);
        return $this->showMessageWithRedirectRoute('گارانتی شما با موفقیت ویرایش شد');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Guarantee $guarantee
     * @return RedirectResponse
     */
    public function destroy(Guarantee $guarantee): RedirectResponse
    {
        $guarantee->delete();
        return $this->showMessageWithRedirectRoute('گارانتی شما با موفقیت حذف شد');
    }

    /**
     * @param Guarantee $guarantee
     * @return JsonResponse
     */
    public function status(Guarantee $guarantee): JsonResponse
    {
        return ShareService::ajaxChangeModelSpecialField($guarantee);
    }
}

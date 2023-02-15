<?php

namespace Modules\Product\Http\Controllers;


use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\Product\Entities\Guarantee;
use Modules\Product\Entities\Product;
use Modules\Product\Http\Requests\ProductGalleryRequest;
use Modules\Product\Http\Requests\ProductGuaranteeRequest;
use Modules\Product\Repositories\Guarantee\ProductGuaranteeRepoEloquentInterface;
use Modules\Product\Services\Guarantee\ProductGuaranteeService;
use Modules\Share\Http\Controllers\Controller;
use Modules\Share\Services\ShareService;
use Modules\Share\Traits\ShowMessageWithRedirectTrait;

class GuaranteeController extends Controller
{
    use ShowMessageWithRedirectTrait;

    /**
     * @var string
     */
    private string $redirectRoute = 'product.guarantee.index';

    /**
     * @var string
     */
    private string $class = Guarantee::class;

    public ProductGuaranteeRepoEloquentInterface $repo;
    public ProductGuaranteeService $service;

    /**
     * @param ProductGuaranteeRepoEloquentInterface $guaranteeRepoEloquent
     * @param ProductGuaranteeService $guaranteeService
     */
    public function __construct(ProductGuaranteeRepoEloquentInterface $guaranteeRepoEloquent, ProductGuaranteeService $guaranteeService)
    {
        $this->repo = $guaranteeRepoEloquent;
        $this->service = $guaranteeService;

        $this->middleware('can:permission product guarantees')->only(['index']);
        $this->middleware('can:permission product guarantee create')->only(['create', 'store']);
        $this->middleware('can:permission product guarantee delete')->only(['destroy']);
    }

    /**
     * @param Product $product
     * @return Application|Factory|View|RedirectResponse
     */
    public function index(Product $product): Factory|View|Application|RedirectResponse
    {
        if (isset(request()->search)) {
            $guarantees = $this->repo->search(request()->search, $product->id)->paginate(10);
            if (count($guarantees) > 0) {
                $this->showToastOfFetchedRecordsCount(count($guarantees));
            } else {
                return $this->showAlertOfNotResultFound();
            }
        } else {
            $guarantees = $product->guarantees()->paginate(10);
        }

        return view('Product::admin.guarantee.index', compact(['product', 'guarantees']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Product $product
     * @return Application|Factory|View
     */
    public function create(Product $product): View|Factory|Application
    {
        return view('Product::admin.guarantee.create', compact(['product']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProductGuaranteeRequest $request
     * @param Product $product
     * @return RedirectResponse
     */
    public function store(ProductGuaranteeRequest $request, Product $product): RedirectResponse
    {
        $this->service->store($request, $product->id);
        return $this->showMessageWithRedirectRoute('گارانتی شما با موفقیت ثبت شد', params: [$product]);
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
     * @param Product $product
     * @param Guarantee $guarantee
     * @return Application|Factory|View
     */
    public function edit(Product $product, Guarantee $guarantee): View|Factory|Application
    {
        return view('Product::admin.guarantee.edit', compact(['product', 'guarantee']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProductGuaranteeRequest $request
     * @param Product $product
     * @param Guarantee $guarantee
     * @return RedirectResponse
     */
    public function update(ProductGuaranteeRequest $request, Product $product, Guarantee $guarantee): RedirectResponse
    {
        $this->service->update($request, $product->id, $guarantee);
        return $this->showMessageWithRedirectRoute('گارانتی شما با موفقیت ویرایش شد', params: [$product]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Product $product
     * @param Guarantee $guarantee
     * @return RedirectResponse
     */
    public function destroy(Product $product, Guarantee $guarantee): RedirectResponse
    {
        $guarantee->delete();
        return $this->showMessageWithRedirectRoute('گارانتی شما با موفقیت حذف شد', params: [$product]);
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

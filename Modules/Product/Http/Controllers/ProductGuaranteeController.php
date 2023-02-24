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
use Modules\Product\Entities\ProductGuarantee;
use Modules\Product\Http\Requests\ProductGalleryRequest;
use Modules\Product\Http\Requests\ProductGuaranteeRequest;
use Modules\Product\Repositories\Guarantee\GuaranteeRepoEloquentInterface;
use Modules\Product\Repositories\ProductGuarantee\ProductGuaranteeRepoEloquentInterface;
use Modules\Product\Services\ProductGuarantee\ProductGuaranteeService;
use Modules\Share\Http\Controllers\Controller;
use Modules\Share\Services\ShareService;
use Modules\Share\Traits\ShowMessageWithRedirectTrait;

class ProductGuaranteeController extends Controller
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

        $this->middleware('can:' . Permission::PERMISSION_PRODUCT_GUARANTEES)->only(['index']);
        $this->middleware('can:' . Permission::PERMISSION_PRODUCT_GUARANTEE_CREATE)->only(['create', 'store']);
        $this->middleware('can:' . Permission::PERMISSION_PRODUCT_GUARANTEE_EDIT)->only(['edit', 'update']);
        $this->middleware('can:' . Permission::PERMISSION_PRODUCT_GUARANTEE_DELETE)->only(['destroy']);
        $this->middleware('can:' . Permission::PERMISSION_PRODUCT_GUARANTEE_STATUS)->only(['status']);
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
        } elseif (isset(request()->sort)) {
            $guarantees = $this->repo->sort(request()->sort, request()->dir, $product->id)->paginate(10);
            if (count($guarantees) > 0) {
                $this->showToastOfSelectedDirection(request()->dir);
            }
            else { $this->showToastOfNotDataExists(); }
        } else {
            $guarantees = $product->guarantees()->paginate(10);
        }

        return view('Product::admin.product-guarantee.index', compact(['product', 'guarantees']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Product $product
     * @param GuaranteeRepoEloquentInterface $guaranteeRepo
     * @return Application|Factory|View
     */
    public function create(Product $product, GuaranteeRepoEloquentInterface $guaranteeRepo): View|Factory|Application
    {
        $guarantees = $guaranteeRepo->getLatest()->get()->except($product->guarantees()->pluck('guarantee_id')->toArray());
        return view('Product::admin.product-guarantee.create', compact(['product', 'guarantees']));
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
     * @param ProductGuarantee $guarantee
     * @param GuaranteeRepoEloquentInterface $guaranteeRepo
     * @return Application|Factory|View
     */
    public function edit(Product $product, ProductGuarantee $guarantee, GuaranteeRepoEloquentInterface $guaranteeRepo): View|Factory|Application
    {
        $guarantees = $guaranteeRepo->getLatest()->get()->except($product->guarantees()->get()->except($guarantee->id)->pluck('guarantee_id')->toArray());
        return view('Product::admin.product-guarantee.edit', compact(['product', 'guarantee', 'guarantees']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProductGuaranteeRequest $request
     * @param Product $product
     * @param ProductGuarantee $guarantee
     * @return RedirectResponse
     */
    public function update(ProductGuaranteeRequest $request, Product $product, ProductGuarantee $guarantee): RedirectResponse
    {
        $this->service->update($request, $product->id, $guarantee);
        return $this->showMessageWithRedirectRoute('گارانتی شما با موفقیت ویرایش شد', params: [$product]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Product $product
     * @param ProductGuarantee $guarantee
     * @return RedirectResponse
     */
    public function destroy(Product $product, ProductGuarantee $guarantee): RedirectResponse
    {
        $guarantee->delete();
        return $this->showMessageWithRedirectRoute('گارانتی شما با موفقیت حذف شد', params: [$product]);
    }

    /**
     * @param ProductGuarantee $guarantee
     * @return JsonResponse
     */
    public function status(ProductGuarantee $guarantee): JsonResponse
    {
        return ShareService::ajaxChangeModelSpecialField($guarantee);
    }
}

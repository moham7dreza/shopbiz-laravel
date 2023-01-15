<?php

namespace Modules\Discount\Http\Controllers;


use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Modules\Discount\Entities\AmazingSale;
use Modules\Discount\Http\Requests\AmazingSaleRequest;
use Modules\Discount\Repositories\AmazingSale\AmazingSaleDiscountRepoEloquentInterface;
use Modules\Discount\Services\AmazingSale\AmazingSaleDiscountService;
use Modules\Product\Entities\Product;
use Modules\Product\Repositories\Product\ProductRepoEloquentInterface;
use Modules\Share\Http\Controllers\Controller;
use Modules\Share\Services\ShareService;

class AmazingSaleController extends Controller
{
    /**
     * @var string
     */
    public string $redirectRoute = 'amazingSale.index';

    /**
     * @var string
     */
    private string $class = AmazingSale::class;

    public AmazingSaleDiscountRepoEloquentInterface $amazingSaleDiscountRepo;
    public AmazingSaleDiscountService $amazingSaleDiscountService;

    /**
     * @param AmazingSaleDiscountRepoEloquentInterface $amazingSaleDiscountRepo
     * @param AmazingSaleDiscountService $amazingSaleDiscountService
     */
    public function __construct(AmazingSaleDiscountRepoEloquentInterface $amazingSaleDiscountRepo, AmazingSaleDiscountService $amazingSaleDiscountService)
    {
        $this->amazingSaleDiscountRepo = $amazingSaleDiscountRepo;
        $this->amazingSaleDiscountService = $amazingSaleDiscountService;

        // set middlewares
        $this->middleware('can:permission-product-amazing-sales')->only(['amazingSale']);
        $this->middleware('can:permission-product-amazing-sale-create')->only(['amazingSaleCreate', 'amazingSaleStore']);
        $this->middleware('can:permission-product-amazing-sale-edit')->only(['amazingSaleEdit', 'amazingSaleUpdate']);
        $this->middleware('can:permission-product-amazing-sale-delete')->only(['amazingSaleDestroy']);
    }

    /**
     * @return Application|Factory|View
     */
    public function index(): View|Factory|Application
    {
        $amazingSales = $this->amazingSaleDiscountRepo->getLatest()->paginate(10);
        return view('Discount::amazingSale.index', compact(['amazingSales']));
    }

    /**
     * @param ProductRepoEloquentInterface $productRepo
     * @return Application|Factory|View
     */
    public function create(ProductRepoEloquentInterface $productRepo): View|Factory|Application
    {
        $products = $productRepo->index()->get();
        return view('Discount::amazingSale.create', compact(['products']));
    }

    /**
     * @param AmazingSaleRequest $request
     * @return RedirectResponse
     */
    public function store(AmazingSaleRequest $request): RedirectResponse
    {
        $inputs = $request->all();
        //date fixed
        $realTimestampStart = substr($request->start_date, 0, 10);
        $inputs['start_date'] = date("Y-m-d H:i:s", (int)$realTimestampStart);
        $realTimestampEnd = substr($request->end_date, 0, 10);
        $inputs['end_date'] = date("Y-m-d H:i:s", (int)$realTimestampEnd);
        $amazingSale = AmazingSale::query()->create($inputs);
        return redirect()->route('amazingSale.index')->with('swal-success', ' تخفیف جدید شما با موفقیت ثبت شد');
    }

    /**
     * @param AmazingSale $amazingSale
     * @param ProductRepoEloquentInterface $productRepo
     * @return View|Factory|Application
     */
    public function edit(AmazingSale $amazingSale, ProductRepoEloquentInterface $productRepo): View|Factory|Application
    {
        $products = $productRepo->index()->get();
        return view('Discount::amazingSale.edit', compact(['amazingSale', 'products']));
    }

    /**
     * @param AmazingSaleRequest $request
     * @param AmazingSale $amazingSale
     * @return RedirectResponse
     */
    public function update(AmazingSaleRequest $request, AmazingSale $amazingSale): RedirectResponse
    {
        $inputs = $request->all();
        //date fixed
        $realTimestampStart = substr($request->start_date, 0, 10);
        $inputs['start_date'] = date("Y-m-d H:i:s", (int)$realTimestampStart);
        $realTimestampEnd = substr($request->end_date, 0, 10);
        $inputs['end_date'] = date("Y-m-d H:i:s", (int)$realTimestampEnd);
        $amazingSale->update($inputs);
        return redirect()->route('amazingSale.index')->with('swal-success', ' تخفیف  شما با موفقیت ویرایش شد');
    }


    /**
     * @param AmazingSale $amazingSale
     * @return RedirectResponse
     */
    public function destroy(AmazingSale $amazingSale): RedirectResponse
    {
        $result = $amazingSale->delete();
        return redirect()->route('amazingSale.index')->with('swal-success', ' تخفیف  شما با موفقیت حذف شد');
    }

    /**
     * @param AmazingSale $amazingSale
     * @return JsonResponse
     */
    public function status(AmazingSale $amazingSale): JsonResponse
    {
        return ShareService::changeStatus($amazingSale);
    }
}

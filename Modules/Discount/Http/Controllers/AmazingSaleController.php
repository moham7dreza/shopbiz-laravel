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
use Modules\Share\Http\Controllers\Controller;

class AmazingSaleController extends Controller
{
    public string $redirectRoute = 'amazingSale.index';

    public AmazingSaleDiscountRepoEloquentInterface $amazingSaleDiscountRepo;
    public AmazingSaleDiscountService $amazingSaleDiscountService;

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
        $amazingSales = AmazingSale::all();
        return view('Discount::amazingSale.index', compact('amazingSales'));
    }

    /**
     * @return Application|Factory|View
     */
    public function create(): View|Factory|Application
    {
        $products = Product::all();
        return view('Discount::amazingSale.create', compact('products'));
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
     * @return View|Factory|Application
     */
    public function edit(AmazingSale $amazingSale): View|Factory|Application
    {
        $products = Product::all();
        return view('Discount::amazingSale.edit', compact('amazingSale', 'products'));
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
        $amazingSale->status = $amazingSale->status == 0 ? 1 : 0;
        $result = $amazingSale->save();
        if ($result) {
            if ($amazingSale->status == 0) {
                return response()->json(['status' => true, 'checked' => false]);
            } else {
                return response()->json(['status' => true, 'checked' => true]);
            }
        } else {
            return response()->json(['status' => false]);
        }
    }
}

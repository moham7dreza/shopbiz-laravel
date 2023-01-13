<?php

namespace Modules\Discount\Http\Controllers;


use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Modules\Discount\Entities\CommonDiscount;
use Modules\Discount\Http\Requests\CommonDiscountRequest;
use Modules\Discount\Repositories\Common\CommonDiscountRepoEloquentInterface;
use Modules\Discount\Services\Common\CommonDiscountService;
use Modules\Share\Http\Controllers\Controller;

class CommonController extends Controller
{
    public string $redirectRoute = 'commonDiscount.index';

    public CommonDiscountRepoEloquentInterface $commonDiscountRepo;
    public CommonDiscountService $commonDiscountService;

    public function __construct(CommonDiscountRepoEloquentInterface $commonDiscountRepo, CommonDiscountService $commonDiscountService)
    {
        $this->commonDiscountRepo = $commonDiscountRepo;
        $this->commonDiscountService = $commonDiscountService;

        // set middlewares
        $this->middleware('can:permission-product-common-discounts')->only(['commonDiscount']);
        $this->middleware('can:permission-product-common-discount-create')->only(['commonDiscountCreate', 'commonDiscountStore']);
        $this->middleware('can:permission-product-common-discount-edit')->only(['commonDiscountEdit', 'commonDiscountUpdate']);
        $this->middleware('can:permission-product-common-discount-delete')->only(['commonDiscountDestroy']);
    }


    /**
     * @return Application|Factory|View
     */
    public function index(): View|Factory|Application
    {
        $commonDiscounts = CommonDiscount::all();
        return view('Discount::common.index', compact('commonDiscounts'));
    }

    /**
     * @return Application|Factory|View
     */
    public function create(): View|Factory|Application
    {
        return view('Discount::common.create');
    }

    /**
     * @param CommonDiscountRequest $request
     * @return RedirectResponse
     */
    public function store(CommonDiscountRequest $request): RedirectResponse
    {
        $inputs = $request->all();
        //date fixed
        $realTimestampStart = substr($request->start_date, 0, 10);
        $inputs['start_date'] = date("Y-m-d H:i:s", (int)$realTimestampStart);
        $realTimestampEnd = substr($request->end_date, 0, 10);
        $inputs['end_date'] = date("Y-m-d H:i:s", (int)$realTimestampEnd);
        $commonDiscount = CommonDiscount::query()->create($inputs);
        return redirect()->route('commonDiscount.index')->with('swal-success', 'کد تخفیف جدید شما با موفقیت ثبت شد');
    }


    /**
     * @param CommonDiscount $commonDiscount
     * @return Application|Factory|View
     */
    public function edit(CommonDiscount $commonDiscount): View|Factory|Application
    {
        return view('Discount::common.edit', compact('commonDiscount'));
    }

    /**
     * @param CommonDiscountRequest $request
     * @param CommonDiscount $commonDiscount
     * @return RedirectResponse
     */
    public function update(CommonDiscountRequest $request, CommonDiscount $commonDiscount): RedirectResponse
    {
        $inputs = $request->all();
        //date fixed
        $realTimestampStart = substr($request->start_date, 0, 10);
        $inputs['start_date'] = date("Y-m-d H:i:s", (int)$realTimestampStart);
        $realTimestampEnd = substr($request->end_date, 0, 10);
        $inputs['end_date'] = date("Y-m-d H:i:s", (int)$realTimestampEnd);
        $commonDiscount->update($inputs);
        return redirect()->route('commonDiscount.index')->with('swal-success', 'کد تخفیف جدید شما با موفقیت ویرایش شد');
    }

    /**
     * @param CommonDiscount $commonDiscount
     * @return RedirectResponse
     */
    public function destroy(CommonDiscount $commonDiscount): RedirectResponse
    {
        $result = $commonDiscount->delete();
        return redirect()->route('commonDiscount.index')->with('swal-success', 'کد تخفیف  شما با موفقیت حذف شد');
    }

    /**
     * @param CommonDiscount $commonDiscount
     * @return JsonResponse
     */
    public function status(CommonDiscount $commonDiscount): JsonResponse
    {
        $commonDiscount->status = $commonDiscount->status == 0 ? 1 : 0;
        $result = $commonDiscount->save();
        if ($result) {
            if ($commonDiscount->status == 0) {
                return response()->json(['status' => true, 'checked' => false]);
            } else {
                return response()->json(['status' => true, 'checked' => true]);
            }
        } else {
            return response()->json(['status' => false]);
        }
    }
}

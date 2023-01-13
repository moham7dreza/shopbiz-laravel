<?php

namespace Modules\Discount\Http\Controllers;


use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Modules\Discount\Entities\Copan;
use Modules\Discount\Http\Requests\CopanRequest;
use Modules\Discount\Repositories\Copan\CopanDiscountRepoEloquentInterface;
use Modules\Discount\Services\Copan\CopanDiscountService;
use Modules\Share\Http\Controllers\Controller;
use Modules\User\Entities\User;

class CopanController extends Controller
{

    public string $redirectRoute = 'copanDiscount.index';
    public CopanDiscountRepoEloquentInterface $copanDiscountRepo;
    public CopanDiscountService $copanDiscountService;

    public function __construct(CopanDiscountRepoEloquentInterface $copanDiscountRepo, CopanDiscountService $copanDiscountService,)
    {
        $this->copanDiscountRepo = $copanDiscountRepo;
        $this->copanDiscountService = $copanDiscountService;

        // set middlewares
        $this->middleware('can:permission-product-coupon-discounts')->only(['copan']);
        $this->middleware('can:permission-product-coupon-discount-create')->only(['copanCreate', 'copanStore']);
        $this->middleware('can:permission-product-coupon-discount-edit')->only(['copanEdit', 'copanUpdate']);
        $this->middleware('can:permission-product-coupon-discount-delete')->only(['copanDestroy']);
    }

    /**
     * @return Application|Factory|View
     */
    public function index(): Factory|View|Application
    {
        $copans = $this->copanDiscountRepo->getLatest()->paginate(10);
        return view('Discount::copan.index', compact('copans'));
    }

    /**
     * @return Application|Factory|View
     */
    public function create(): View|Factory|Application
    {
        $users = User::all();
        return view('Discount::copan.create', compact('users'));
    }

    /**
     * @param CopanRequest $request
     * @return RedirectResponse
     */
    public function store(CopanRequest $request): RedirectResponse
    {
        $inputs = $request->all();
        //date fixed
        $realTimestampStart = substr($request->start_date, 0, 10);
        $inputs['start_date'] = date("Y-m-d H:i:s", (int)$realTimestampStart);
        $realTimestampEnd = substr($request->end_date, 0, 10);
        $inputs['end_date'] = date("Y-m-d H:i:s", (int)$realTimestampEnd);
        if ($inputs['type'] == 0) {
            $inputs['user_id'] = null;
        }
        Copan::query()->create($inputs);
        return redirect()->route('copanDiscount.index')->with('swal-success', ' کد تخفیف جدید شما با موفقیت ثبت شد');
    }


    /**
     * @param Copan $copanDiscount
     * @return Application|Factory|View
     */
    public function edit(Copan $copanDiscount): View|Factory|Application
    {
        $users = User::all();
        return view('Discount::copan.edit', compact('copanDiscount', 'users'));
    }

    /**
     * @param CopanRequest $request
     * @param Copan $copanDiscount
     * @return RedirectResponse
     */
    public function update(CopanRequest $request, Copan $copanDiscount): RedirectResponse
    {
        $inputs = $request->all();
        //date fixed
        $realTimestampStart = substr($request->start_date, 0, 10);
        $inputs['start_date'] = date("Y-m-d H:i:s", (int)$realTimestampStart);
        $realTimestampEnd = substr($request->end_date, 0, 10);
        $inputs['end_date'] = date("Y-m-d H:i:s", (int)$realTimestampEnd);
        if ($inputs['type'] == 0) {
            $inputs['user_id'] = null;
        }
        $copanDiscount->update($inputs);
        return redirect()->route('copanDiscount.index')->with('swal-success', 'کد تخفیف  شما با موفقیت ویرایش شد');
    }


    /**
     * @param Copan $copanDiscount
     * @return RedirectResponse
     */
    public function destroy(Copan $copanDiscount): RedirectResponse
    {
        $result = $copanDiscount->delete();
        return redirect()->route('copanDiscount.index')->with('swal-success', ' تخفیف  شما با موفقیت حذف شد');
    }

    /**
     * @param Copan $copanDiscount
     * @return JsonResponse
     */
    public function status(Copan $copanDiscount): JsonResponse
    {
        $copanDiscount->status = $copanDiscount->status == 0 ? 1 : 0;
        $result = $copanDiscount->save();
        if ($result) {
            if ($copanDiscount->status == 0) {
                return response()->json(['status' => true, 'checked' => false]);
            } else {
                return response()->json(['status' => true, 'checked' => true]);
            }
        } else {
            return response()->json(['status' => false]);
        }
    }
}

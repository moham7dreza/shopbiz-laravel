<?php

namespace Modules\Discount\Http\Controllers;


use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Modules\Discount\Entities\AmazingSale;
use Modules\Discount\Entities\CommonDiscount;
use Modules\Discount\Entities\Copan;
use Modules\Discount\Http\Requests\AmazingSaleRequest;
use Modules\Discount\Http\Requests\CommonDiscountRequest;
use Modules\Discount\Http\Requests\CopanRequest;
use Modules\Product\Entities\Product;
use Modules\Share\Http\Controllers\Controller;
use Modules\User\Entities\User;

class DiscountController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function copan()
    {
        $copans = Copan::all();
        return view('Discount::copan', compact('copans'));
    }

    /**
     * @return Application|Factory|View
     */
    public function copanCreate()
    {
        $users = User::all();
        return view('Discount::copan-create', compact('users'));
    }

    /**
     * @param CopanRequest $request
     * @return RedirectResponse
     */
    public function copanStore(CopanRequest $request): RedirectResponse
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
        $amazingSale = Copan::query()->create($inputs);
        return redirect()->route('discount.copan')->with('swal-success', ' کد تخفیف جدید شما با موفقیت ثبت شد');
    }


    /**
     * @param Copan $copan
     * @return Application|Factory|View
     */
    public function copanEdit(Copan $copan)
    {
        $users = User::all();
        return view('discount.copan-edit', compact('copan', 'users'));
    }

    /**
     * @param CopanRequest $request
     * @param Copan $copan
     * @return RedirectResponse
     */
    public function copanUpdate(CopanRequest $request, Copan $copan)
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
        $copan->update($inputs);
        return redirect()->route('discount.copan')->with('swal-success', 'کد تخفیف  شما با موفقیت ویرایش شد');
    }


    /**
     * @param Copan $copan
     * @return RedirectResponse
     */
    public function copanDestroy(Copan $copan)
    {
        $result = $copan->delete();
        return redirect()->route('discount.copan')->with('swal-success', ' تخفیف  شما با موفقیت حذف شد');
    }

    /**
     * @return Application|Factory|View
     */
    public function commonDiscount()
    {
        $commonDiscounts = CommonDiscount::all();
        return view('Discount::common', compact('commonDiscounts'));
    }

    /**
     * @return Application|Factory|View
     */
    public function commonDiscountCreate()
    {
        return view('Discount::common-create');
    }

    /**
     * @param CommonDiscountRequest $request
     * @return RedirectResponse
     */
    public function commonDiscountStore(CommonDiscountRequest $request): RedirectResponse
    {
        $inputs = $request->all();
        //date fixed
        $realTimestampStart = substr($request->start_date, 0, 10);
        $inputs['start_date'] = date("Y-m-d H:i:s", (int)$realTimestampStart);
        $realTimestampEnd = substr($request->end_date, 0, 10);
        $inputs['end_date'] = date("Y-m-d H:i:s", (int)$realTimestampEnd);
        $commonDiscount = CommonDiscount::query()->create($inputs);
        return redirect()->route('discount.commonDiscount')->with('swal-success', 'کد تخفیف جدید شما با موفقیت ثبت شد');
    }


    /**
     * @param CommonDiscount $commonDiscount
     * @return Application|Factory|View
     */
    public function commonDiscountEdit(CommonDiscount $commonDiscount)
    {
        return view('Discount::common-edit', compact('commonDiscount'));
    }

    /**
     * @param CommonDiscountRequest $request
     * @param CommonDiscount $commonDiscount
     * @return RedirectResponse
     */
    public function commonDiscountUpdate(CommonDiscountRequest $request, CommonDiscount $commonDiscount): RedirectResponse
    {
        $inputs = $request->all();
        //date fixed
        $realTimestampStart = substr($request->start_date, 0, 10);
        $inputs['start_date'] = date("Y-m-d H:i:s", (int)$realTimestampStart);
        $realTimestampEnd = substr($request->end_date, 0, 10);
        $inputs['end_date'] = date("Y-m-d H:i:s", (int)$realTimestampEnd);
        $commonDiscount->update($inputs);
        return redirect()->route('discount.commonDiscount')->with('swal-success', 'کد تخفیف جدید شما با موفقیت ویرایش شد');
    }

    /**
     * @param CommonDiscount $commonDiscount
     * @return RedirectResponse
     */
    public function commonDiscountDestroy(CommonDiscount $commonDiscount): RedirectResponse
    {
        $result = $commonDiscount->delete();
        return redirect()->route('discount.commonDiscount')->with('swal-success', 'کد تخفیف  شما با موفقیت حذف شد');
    }

    /**
     * @return Application|Factory|View
     */
    public function amazingSale()
    {
        $amazingSales = AmazingSale::all();
        return view('Discount::amazing', compact('amazingSales'));
    }

    /**
     * @return Application|Factory|View
     */
    public function amazingSaleCreate()
    {
        $products = Product::all();
        return view('Discount::amazing-create', compact('products'));
    }

    /**
     * @param AmazingSaleRequest $request
     * @return RedirectResponse
     */
    public function amazingSaleStore(AmazingSaleRequest $request): RedirectResponse
    {
        $inputs = $request->all();
        //date fixed
        $realTimestampStart = substr($request->start_date, 0, 10);
        $inputs['start_date'] = date("Y-m-d H:i:s", (int)$realTimestampStart);
        $realTimestampEnd = substr($request->end_date, 0, 10);
        $inputs['end_date'] = date("Y-m-d H:i:s", (int)$realTimestampEnd);
        $amazingSale = AmazingSale::query()->create($inputs);
        return redirect()->route('discount.amazingSale')->with('swal-success', ' تخفیف جدید شما با موفقیت ثبت شد');
    }

    public function amazingSaleEdit(AmazingSale $amazingSale)
    {
        $products = Product::all();
        return view('discount.amazing-edit', compact('amazingSale', 'products'));
    }

    /**
     * @param AmazingSaleRequest $request
     * @param AmazingSale $amazingSale
     * @return RedirectResponse
     */
    public function amazingSaleUpdate(AmazingSaleRequest $request, AmazingSale $amazingSale): RedirectResponse
    {
        $inputs = $request->all();
        //date fixed
        $realTimestampStart = substr($request->start_date, 0, 10);
        $inputs['start_date'] = date("Y-m-d H:i:s", (int)$realTimestampStart);
        $realTimestampEnd = substr($request->end_date, 0, 10);
        $inputs['end_date'] = date("Y-m-d H:i:s", (int)$realTimestampEnd);
        $amazingSale->update($inputs);
        return redirect()->route('discount.amazingSale')->with('swal-success', ' تخفیف  شما با موفقیت ویرایش شد');
    }


    /**
     * @param AmazingSale $amazingSale
     * @return RedirectResponse
     */
    public function amazingSaleDestroy(AmazingSale $amazingSale): RedirectResponse
    {
        $result = $amazingSale->delete();
        return redirect()->route('discount.amazingSale')->with('swal-success', ' تخفیف  شما با موفقیت حذف شد');
    }
}

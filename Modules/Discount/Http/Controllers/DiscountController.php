<?php

namespace Modules\Discount\Http\Controllers;


use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Modules\Discount\Entities\AmazingSale;
use Modules\Discount\Entities\CommonDiscount;
use Modules\Discount\Entities\Copan;
use Modules\Product\Entities\Product;
use Modules\Share\Http\Controllers\Controller;

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

    public function copanStore(CopanRequest $request)
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
        $amazingSale = Copan::create($inputs);
        return redirect()->route('admin.market.discount.copan')->with('swal-success', ' کد تخفیف جدید شما با موفقیت ثبت شد');
    }


    public function copanEdit(Copan $copan)
    {
        $users = User::all();
        return view('admin.market.discount.copan-edit', compact('copan', 'users'));
    }

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
        return redirect()->route('admin.market.discount.copan')->with('swal-success', 'کد تخفیف  شما با موفقیت ویرایش شد');
    }


    public function copanDestroy(Copan $copan)
    {
        $result = $copan->delete();
        return redirect()->route('admin.market.discount.copan')->with('swal-success', ' تخفیف  شما با موفقیت حذف شد');
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
        return view('Discount.common-create');
    }

    public function commonDiscountStore(CommonDiscountRequest $request)
    {
        $inputs = $request->all();
        //date fixed
        $realTimestampStart = substr($request->start_date, 0, 10);
        $inputs['start_date'] = date("Y-m-d H:i:s", (int)$realTimestampStart);
        $realTimestampEnd = substr($request->end_date, 0, 10);
        $inputs['end_date'] = date("Y-m-d H:i:s", (int)$realTimestampEnd);
        $commonDiscount = CommonDiscount::create($inputs);
        return redirect()->route('admin.market.discount.commonDiscount')->with('swal-success', 'کد تخفیف جدید شما با موفقیت ثبت شد');
    }


    public function commonDiscountEdit(CommonDiscount $commonDiscount)
    {
        return view('admin.market.discount.common-edit', compact('commonDiscount'));
    }

    public function commonDiscountUpdate(CommonDiscountRequest $request, CommonDiscount $commonDiscount)
    {
        $inputs = $request->all();
        //date fixed
        $realTimestampStart = substr($request->start_date, 0, 10);
        $inputs['start_date'] = date("Y-m-d H:i:s", (int)$realTimestampStart);
        $realTimestampEnd = substr($request->end_date, 0, 10);
        $inputs['end_date'] = date("Y-m-d H:i:s", (int)$realTimestampEnd);
        $commonDiscount->update($inputs);
        return redirect()->route('admin.market.discount.commonDiscount')->with('swal-success', 'کد تخفیف جدید شما با موفقیت ویرایش شد');
    }

    public function commonDiscountDestroy(CommonDiscount $commonDiscount)
    {
        $result = $commonDiscount->delete();
        return redirect()->route('admin.market.discount.commonDiscount')->with('swal-success', 'کد تخفیف  شما با موفقیت حذف شد');
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

    public function amazingSaleStore(AmazingSaleRequest $request)
    {
        $inputs = $request->all();
        //date fixed
        $realTimestampStart = substr($request->start_date, 0, 10);
        $inputs['start_date'] = date("Y-m-d H:i:s", (int)$realTimestampStart);
        $realTimestampEnd = substr($request->end_date, 0, 10);
        $inputs['end_date'] = date("Y-m-d H:i:s", (int)$realTimestampEnd);
        $amazingSale = AmazingSale::create($inputs);
        return redirect()->route('admin.market.discount.amazingSale')->with('swal-success', ' تخفیف جدید شما با موفقیت ثبت شد');
    }

    public function amazingSaleEdit(AmazingSale $amazingSale)
    {
        $products = Product::all();
        return view('admin.market.discount.amazing-edit', compact('amazingSale', 'products'));
    }

    public function amazingSaleUpdate(AmazingSaleRequest $request, AmazingSale $amazingSale)
    {
        $inputs = $request->all();
        //date fixed
        $realTimestampStart = substr($request->start_date, 0, 10);
        $inputs['start_date'] = date("Y-m-d H:i:s", (int)$realTimestampStart);
        $realTimestampEnd = substr($request->end_date, 0, 10);
        $inputs['end_date'] = date("Y-m-d H:i:s", (int)$realTimestampEnd);
        $amazingSale->update($inputs);
        return redirect()->route('admin.market.discount.amazingSale')->with('swal-success', ' تخفیف  شما با موفقیت ویرایش شد');
    }


    public function amazingSaleDestroy(AmazingSale $amazingSale)
    {
        $result = $amazingSale->delete();
        return redirect()->route('admin.market.discount.amazingSale')->with('swal-success', ' تخفیف  شما با موفقیت حذف شد');
    }
}

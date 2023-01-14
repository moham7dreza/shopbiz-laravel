<?php

namespace Modules\Home\Http\Controllers\SalesProcess;


use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Modules\Cart\Entities\CartItem;
use Modules\Delivery\Entities\Delivery;
use Modules\Discount\Entities\CommonDiscount;
use Modules\Home\Http\Requests\SalesProcess\ChooseAddressAndDeliveryRequest;
use Modules\Home\Http\Requests\SalesProcess\StoreAddressRequest;
use Modules\Home\Http\Requests\SalesProcess\UpdateAddressRequest;
use Modules\Order\Entities\Order;
use Modules\Share\Http\Controllers\Controller;
use Modules\User\Entities\Address;
use Modules\User\Entities\Province;

class AddressController extends Controller
{
    /**
     * @return Application|Factory|View|RedirectResponse
     */
    public function addressAndDelivery(): View|Factory|RedirectResponse|Application
    {
        //check profile
        $user = Auth::user();
        $provinces = Province::all();
        $cartItems = CartItem::query()->where('user_id', $user->id)->get();
        $deliveryMethods = Delivery::query()->where('status', 1)->get();

        if (empty(CartItem::query()->where('user_id', $user->id)->count())) {
            return redirect()->route('customer.sales-process.cart');
        }

        return view('Home::sales-process.address-and-delivery', compact('cartItems', 'provinces', 'deliveryMethods'));
    }


    /**
     * @param Province $province
     * @return JsonResponse
     */
    public function getCities(Province $province): JsonResponse
    {
        $cities = $province->cities;
        if ($cities != null) {
            return response()->json(['status' => true, 'cities' => $cities]);
        } else {
            return response()->json(['status' => false, 'cities' => null]);
        }
    }

    /**
     * @param StoreAddressRequest $request
     * @return RedirectResponse
     */
    public function addAddress(StoreAddressRequest $request): RedirectResponse
    {
        $inputs = $request->all();
        $inputs['user_id'] = auth()->user()->id;
        $inputs['postal_code'] = convertArabicToEnglish($request->postal_code);
        $inputs['postal_code'] = convertPersianToEnglish($inputs['postal_code']);
        $address = Address::query()->create($inputs);
        return redirect()->back();
    }

    /**
     * @param Address $address
     * @param UpdateAddressRequest $request
     * @return RedirectResponse
     */
    public function updateAddress(Address $address, UpdateAddressRequest $request): RedirectResponse
    {
        $inputs = $request->all();
        $inputs['user_id'] = auth()->user()->id;
        $inputs['postal_code'] = convertArabicToEnglish($request->postal_code);
        $inputs['postal_code'] = convertPersianToEnglish($inputs['postal_code']);
        $address->update($inputs);
        return redirect()->back();
    }

    /**
     * @param ChooseAddressAndDeliveryRequest $request
     * @return RedirectResponse
     */
    public function chooseAddressAndDelivery(ChooseAddressAndDeliveryRequest $request): RedirectResponse
    {
        $user = auth()->user();
        $inputs = $request->all();

        //calc price
        $cartItems = CartItem::query()->where('user_id', $user->id)->get();
        $totalProductPrice = 0;
        $totalDiscount = 0;
        $totalFinalPrice = 0;
        $totalFinalDiscountPriceWithNumbers = 0;
        foreach ($cartItems as $cartItem) {
            $totalProductPrice += $cartItem->cartItemProductPrice();
            $totalDiscount += $cartItem->cartItemProductDiscount();
            $totalFinalPrice += $cartItem->cartItemFinalPrice();
            $totalFinalDiscountPriceWithNumbers += $cartItem->cartItemFinalDiscount();
        }


        //commonDiscount
        $commonDiscount = CommonDiscount::query()->where([['status', 1], ['end_date', '>', now()], ['start_date', '<', now()]])->first();
        if ($commonDiscount) {
            $inputs['common_discount_id'] = $commonDiscount->id;
            $commonPercentageDiscountAmount = $totalFinalPrice * ($commonDiscount->percentage / 100);
            if ($commonPercentageDiscountAmount > $commonDiscount->discount_ceiling) {
                $commonPercentageDiscountAmount = $commonDiscount->discount_ceiling;
            }
            if ($commonDiscount != null and $totalFinalPrice >= $commonDiscount->minimal_order_amount) {
                $finalPrice = $totalFinalPrice - $commonPercentageDiscountAmount;
            } else {

                $finalPrice = $totalFinalPrice;
            }
        } else {
            $commonPercentageDiscountAmount = null;
            $finalPrice = $totalFinalPrice;
        }


        $inputs['user_id'] = $user->id;
        $inputs['order_final_amount'] = $finalPrice;
        $inputs['order_discount_amount'] = $totalFinalDiscountPriceWithNumbers;
        $inputs['order_common_discount_amount'] = $commonPercentageDiscountAmount;
        $inputs['order_total_products_discount_amount'] = $inputs['order_discount_amount'] + $inputs['order_common_discount_amount'];
        $order = Order::query()->updateOrCreate(
            ['user_id' => $user->id, 'order_status' => 0],
            $inputs
        );
        return redirect()->route('customer.sales-process.payment');
    }
}

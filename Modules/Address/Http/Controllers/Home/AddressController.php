<?php

namespace Modules\Address\Http\Controllers\Home;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Modules\Address\Entities\Address;
use Modules\Address\Entities\Province;
use Modules\Address\Http\Requests\StoreAddressRequest;
use Modules\Address\Http\Requests\UpdateAddressRequest;
use Modules\Address\Repositories\AddressRepoEloquentInterface;
use Modules\Address\Services\AddressService;
use Modules\Cart\Entities\CartItem;
use Modules\Cart\Repositories\CartRepoEloquentInterface;
use Modules\Delivery\Repositories\DeliveryRepoEloquentInterface;
use Modules\Discount\Entities\CommonDiscount;
use Modules\Order\Entities\Order;
use Modules\Share\Http\Controllers\Controller;
use Requests\ChooseAddressAndDeliveryRequest;

class AddressController extends Controller
{

    public AddressRepoEloquentInterface $repo;
    public AddressService $service;

    public function __construct(AddressRepoEloquentInterface $addressRepoEloquent, AddressService $addressService)
    {
        $this->repo = $addressRepoEloquent;
        $this->service = $addressService;
    }

    /**
     * @param CartRepoEloquentInterface $cartRepo
     * @param DeliveryRepoEloquentInterface $deliveryRepo
     * @return Application|Factory|View|RedirectResponse
     */
    public function addressAndDelivery(CartRepoEloquentInterface $cartRepo, DeliveryRepoEloquentInterface $deliveryRepo): View|Factory|RedirectResponse|Application
    {
        $provinces = $this->repo->provinces()->get();
        $cartItems = $cartRepo->findUserCartItems()->get();
        $deliveryMethods = $deliveryRepo->activeMethods()->get();
        $addresses = $this->repo->userAddresses()->get();
        if (empty($cartRepo->findUserCartItems()->count())) {
            return redirect()->route('customer.sales-process.cart');
        }
        return view('Address::address-and-delivery', compact(['cartItems', 'provinces', 'deliveryMethods', 'addresses']));
    }


    /**
     * @param Province $province
     * @return JsonResponse
     */
    public function getCities(Province $province): JsonResponse
    {
        $cities = $province->cities;
        if (!is_null($cities)) {
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
        $this->service->store($request);
        return redirect()->back()->with('success', 'آدرس جدید با موفقیت ثبت شد.');
    }

    /**
     * @param Address $address
     * @param UpdateAddressRequest $request
     * @return RedirectResponse
     */
    public function updateAddress(Address $address, UpdateAddressRequest $request): RedirectResponse
    {
        $this->service->update($request, $address);
        return redirect()->back()->with('info', 'آدرس با موفقیت ویرایش شد.');
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

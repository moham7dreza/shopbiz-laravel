<?php

namespace Modules\Address\Http\Controllers\Home;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Modules\Address\Entities\Address;
use Modules\Address\Entities\Province;
use Modules\Address\Http\Requests\ChooseAddressAndDeliveryRequest;
use Modules\Address\Http\Requests\StoreAddressRequest;
use Modules\Address\Http\Requests\UpdateAddressRequest;
use Modules\Address\Repositories\AddressRepoEloquentInterface;
use Modules\Address\Services\AddressService;
use Modules\Cart\Repositories\CartRepoEloquentInterface;
use Modules\Delivery\Repositories\DeliveryRepoEloquentInterface;
use Modules\Discount\Repositories\Common\CommonDiscountRepoEloquentInterface;
use Modules\Order\Services\OrderService;
use Modules\Share\Http\Controllers\Controller;
use Modules\Share\Services\ShareService;

class AddressController extends Controller
{

    public AddressRepoEloquentInterface $addressRepo;
    public AddressService $addressService;

    public CartRepoEloquentInterface $cartRepo;
    public DeliveryRepoEloquentInterface $deliveryRepo;
    public OrderService $orderService;
    public CommonDiscountRepoEloquentInterface $commonDiscountRepo;

    /**
     * @param AddressRepoEloquentInterface $addressRepoEloquent
     * @param AddressService $addressService
     * @param CartRepoEloquentInterface $cartRepo
     * @param DeliveryRepoEloquentInterface $deliveryRepo
     * @param OrderService $orderService
     * @param CommonDiscountRepoEloquentInterface $commonDiscountRepo
     */
    public function __construct(AddressRepoEloquentInterface  $addressRepoEloquent,
                                AddressService                $addressService,
                                CartRepoEloquentInterface     $cartRepo,
                                DeliveryRepoEloquentInterface $deliveryRepo,
                                OrderService $orderService,
                                CommonDiscountRepoEloquentInterface $commonDiscountRepo)
    {
        $this->addressRepo = $addressRepoEloquent;
        $this->addressService = $addressService;
        $this->deliveryRepo = $deliveryRepo;
        $this->cartRepo = $cartRepo;
        $this->orderService = $orderService;
        $this->commonDiscountRepo = $commonDiscountRepo;
    }

    /**
     * @return Application|Factory|View|RedirectResponse
     */
    public function addressAndDelivery(): View|Factory|RedirectResponse|Application
    {
        $provinces = $this->addressRepo->provinces()->get();
        $cartItems = $this->cartRepo->findUserCartItems()->get();
        $deliveryMethods = $this->deliveryRepo->activeMethods()->get();
        $addresses = $this->addressRepo->userAddresses()->get();
        if (empty($this->cartRepo->findUserCartItems()->count())) {
            toast('سبد خرید شما خالی است.', 'error');
            return redirect()->route('customer.sales-process.cart');
        }
        return view('Address::address-and-delivery', compact([
            'cartItems', 'provinces', 'deliveryMethods', 'addresses'
        ]));
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
        $this->addressService->store($request);
//        return redirect()->back()->with('success', 'آدرس جدید با موفقیت ثبت شد.');
        return ShareService::successAlert('موفقیت آمیز',  'آدرس جدید با موفقیت ثبت شد.');
    }

    /**
     * @param Address $address
     * @param UpdateAddressRequest $request
     * @return RedirectResponse
     */
    public function updateAddress(Address $address, UpdateAddressRequest $request): RedirectResponse
    {
        $this->addressService->update($request, $address);
        return ShareService::infoAlert('موفقیت آمیز',  'آدرس جدید با موفقیت ثبت شد.');
    }

    /**
     * @param ChooseAddressAndDeliveryRequest $request
     * @return RedirectResponse
     */
    public function chooseAddressAndDelivery(ChooseAddressAndDeliveryRequest $request): RedirectResponse
    {
        $cartItems = $this->cartRepo->findUserCartItems()->get();
        $commonDiscount = $this->commonDiscountRepo->activeCommonDiscount();
        $selectedDeliveryMethod = $this->deliveryRepo->findById($request->delivery_id);
        $selectedAddress = $this->addressRepo->findById($request->address_id);
        //
        $calculatedPrices = $this->orderService->calcPrice($cartItems, $commonDiscount);
        //
        $this->orderService->updateOrCreate($commonDiscount, $selectedAddress, $selectedDeliveryMethod, $calculatedPrices);
        toast('آدرس و روش ارسال برای شما ثبت شد.', 'success')->autoClose(5000)->timerProgressBar();
        return redirect()->route('customer.sales-process.payment');
//            ->with('info', 'آدرس و روش ارسال برای شما ثبت شد.');
    }
}

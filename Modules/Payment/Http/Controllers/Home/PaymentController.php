<?php

namespace Modules\Payment\Http\Controllers\Home;

use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Modules\Cart\Repositories\CartRepoEloquentInterface;
use Modules\Discount\Http\Requests\Home\CopanDiscountRequest;
use Modules\Discount\Repositories\Copan\CopanDiscountRepoEloquentInterface;
use Modules\Order\Entities\Order;
use Modules\Order\Repositories\OrderRepoEloquentInterface;
use Modules\Order\Services\OrderService;
use Modules\Payment\Entities\OnlinePayment;
use Modules\Payment\Http\Requests\Home\PaymentRequest;
use Modules\Payment\Services\PaymentServiceInterface;
use Modules\Share\Http\Controllers\Controller;
use Modules\Share\Services\Payment\PaymentService;
use Modules\Share\Traits\ShowMessageWithRedirectTrait;
use Modules\User\Repositories\UserRepoEloquentInterface;


class PaymentController extends Controller
{
    use ShowMessageWithRedirectTrait;

    public CartRepoEloquentInterface $cartRepo;
    public OrderService $orderService;
    public OrderRepoEloquentInterface $orderRepo;
    public CopanDiscountRepoEloquentInterface $copanDiscountRepo;
    public PaymentServiceInterface $paymentService;

    public UserRepoEloquentInterface $userRepo;

    public function __construct(CartRepoEloquentInterface          $cartRepo,
                                OrderService                       $orderService,
                                OrderRepoEloquentInterface         $orderRepo,
                                CopanDiscountRepoEloquentInterface $copanDiscountRepo,
                                PaymentServiceInterface            $paymentService,
                                UserRepoEloquentInterface          $userRepo)
    {
        $this->cartRepo = $cartRepo;
        $this->orderService = $orderService;
        $this->orderRepo = $orderRepo;
        $this->copanDiscountRepo = $copanDiscountRepo;
        $this->paymentService = $paymentService;
        $this->userRepo = $userRepo;
    }

    /**
     * @return Application|Factory|View
     */
    public function payment(): View|Factory|Application
    {
        SEOTools::setTitle('پرداخت');
        SEOTools::setDescription('صفحه پرداخت و انتخاب روش ارسال کال');

        $cartItems = $this->cartRepo->findUserCartItems()->get();
        $order = $this->orderRepo->findUserUncheckedOrder();
        return view('Payment::home.payment', compact(['cartItems', 'order']));
    }

    /**
     * @param CopanDiscountRequest $request
     * @return RedirectResponse
     */
    public function copanDiscount(CopanDiscountRequest $request): RedirectResponse
    {
        $copan = $this->copanDiscountRepo->findActiveCopanDiscountWithCode($request->copan);
        if (!is_null($copan)) {
            // special user copan discount
            if (!is_null($copan->user_id)) {
                $copan = $this->copanDiscountRepo->findActiveCopanDiscountWithCodeAssignedForUser($request->copan);
                if (is_null($copan)) {
                    return $this->showToastWithRedirect(title: 'کد تخفیف اشتباه وارد شده است', type: 'error');
//                    return redirect()->back()->withErrors(['copan' => ['کد تخفیف اشتباه وارد شده است']]);
                }
            }
            // find user submitted order have empty copan record - if not empty that means user is used copan before
            $order = $this->orderRepo->findUserUncheckedOrderWithEmptyCopan();
            if ($order) {
                $copanDiscountAmount = $this->orderService->calcCopanDiscountAmount($copan, $order->order_final_amount);
                $this->orderService->update($order, $copanDiscountAmount, $copan->id);
//                return redirect()->back()->with(['copan' => 'کد تخفیف با موفقیت اعمال شد']);
                return $this->showAlertWithRedirect('کد تخفیف با موفقیت اعمال شد');
            } else {
//                return redirect()->back()->withErrors(['copan' => ['کد تخفیف اشتباه وارد شده است']]);
                return $this->showToastWithRedirect(title: 'کد تخفیف اشتباه وارد شده است', type: 'error');
            }
        } else {
//            return redirect()->back()->withErrors(['copan' => ['کد تخفیف اشتباه وارد شده است']]);
            return $this->showToastWithRedirect(title: 'کد تخفیف اشتباه وارد شده است', type: 'error');
        }
    }

    /**
     * @param PaymentRequest $request
     * @param PaymentService $paymentService
     * @return RedirectResponse
     */
    public function paymentSubmit(PaymentRequest $request, PaymentService $paymentService): RedirectResponse
    {
        $order = $this->orderRepo->findUserUncheckedOrder();
        $orderFinalAmount = $order->order_final_amount;
        $cartItems = $this->cartRepo->findUserCartItems()->get();

        $model = $this->paymentService->findTargetModel($request);
        $paymented = $this->paymentService->storeTargetModel($model['targetModel'],
            $orderFinalAmount, $model['cashReceiver']);

        $payment = $this->paymentService->store($orderFinalAmount, $model['type'],
            $paymented->id, $model['targetModel']);

        // online payment
        if ($request->payment_type == 1) {
            $order->update(['payment_type' => $model['type']]);
            $paymentService->zarinpal($orderFinalAmount, $order, $paymented);
        }
        // offline pay or cash pay
        $this->orderService->lastStepUpdate($order, $model['type'], $payment->id);
        //
        $this->orderService->addOrderItemsAndDeleteAllCartItems($cartItems, $order->id);
        $admin = $this->userRepo->findSystemAdmin();
        $this->orderService->sendOrderSubmittedNotificationToAdmin($admin, $order->id);
        return $this->showAlertWithRedirect(message: 'سفارش شما با موفقیت ثبت شد برای پیگیری سفارش به پروفایل کاربری خود مراجعه کنید', route: 'customer.home');
//        return to_route('customer.home')->with('success', 'سفارش شما با موفقیت ثبت شد');
    }

    /**
     * @param Order $order
     * @param OnlinePayment $onlinePayment
     * @param PaymentService $paymentService
     * @return RedirectResponse
     */
    public function paymentCallback(Order $order, OnlinePayment $onlinePayment, PaymentService $paymentService): RedirectResponse
    {
        $amount = $onlinePayment->amount * 10;
        $result = $paymentService->zarinpalVerify($amount, $onlinePayment);
        $cartItems = $this->cartRepo->findUserCartItems()->get();
        $this->orderService->addOrderItemsAndDeleteAllCartItems($cartItems, $order->id);
        if ($result['success']) {
            $order->update(['order_status' => Order::ORDER_STATUS_CONFIRMED]);
            return $this->showAlertWithRedirect(message: 'پرداخت شما با موفقیت انجام شد', route: 'customer.home');
//            return to_route('customer.home')->with('success', 'پرداخت شما با موفقیت انجام شد');
        } else {
            $order->update(['order_status' => Order::ORDER_STATUS_NOT_CONFIRMED]);
            return $this->showAlertWithRedirect(message: 'سفارش شما با خطا مواجه شد', type: 'error', route: 'customer.home');
//            return to_route('customer.home')->with('danger', 'سفارش شما با خطا مواجه شد');
        }
    }
}

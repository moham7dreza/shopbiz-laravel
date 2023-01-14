<?php

namespace Modules\Payment\Http\Controllers\Home;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Cart\Entities\CartItem;
use Modules\Discount\Entities\Copan;
use Modules\Order\Entities\Order;
use Modules\Order\Entities\OrderItem;
use Modules\Payment\Entities\CashPayment;
use Modules\Payment\Entities\OfflinePayment;
use Modules\Payment\Entities\OnlinePayment;
use Modules\Payment\Entities\Payment;
use Modules\Share\Http\Controllers\Controller;
use Modules\Share\Http\Services\Payment\PaymentService;

class PaymentController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function payment(): View|Factory|Application
    {
        $user = auth()->user();
        $cartItems = CartItem::query()->where('user_id', $user->id)->get();
        $order = Order::query()->where('user_id', Auth::user()->id)->where('order_status', 0)->first();
        return view('Payment::home.payment', compact('cartItems', 'order'));
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function copanDiscount(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate(
            ['copan' => 'required']
        );

        $copan = Copan::query()->where([['code', $request->copan], ['status', 1], ['end_date', '>', now()], ['start_date', '<', now()]])->first();
        if ($copan != null) {
            if ($copan->user_id != null) {
                $copan = Copan::query()->where([['code', $request->copan], ['status', 1], ['end_date', '>', now()], ['start_date', '<', now()], ['user_id', auth()->user()->id]])->first();
                if ($copan == null) {
                    return redirect()->back()->withErrors(['copan' => ['کد تخفیف اشتباه وارد شده است']]);
                }
            }

            $order = Order::query()->where('user_id', Auth::user()->id)->where('order_status', 0)->where('copan_id', null)->first();

            if ($order) {
                if ($copan->amount_type == 0) {
                    $copanDiscountAmount = $order->order_final_amount * ($copan->amount / 100);
                    if ($copanDiscountAmount > $copan->discount_ceiling) {
                        $copanDiscountAmount = $copan->discount_ceiling;
                    }
                } else {
                    $copanDiscountAmount = $copan->amount;
                }

                $order->order_final_amount = $order->order_final_amount - $copanDiscountAmount;

                $finalDiscount = $order->order_total_products_discount_amount + $copanDiscountAmount;

                $order->update(
                    ['copan_id' => $copan->id, 'order_copan_discount_amount' => $copanDiscountAmount, 'order_total_products_discount_amount' => $finalDiscount]
                );

                return redirect()->back()->with(['copan' => 'کد تخفیف با موفقیت اعمال شد']);
            } else {
                return redirect()->back()->withErrors(['copan' => ['کد تخفیف اشتباه وارد شده است']]);
            }
        } else {
            return redirect()->back()->withErrors(['copan' => ['کد تخفیف اشتباه وارد شده است']]);
        }
    }

    /**
     * @param Request $request
     * @param PaymentService $paymentService
     * @return RedirectResponse
     */
    public function paymentSubmit(Request $request, PaymentService $paymentService): RedirectResponse
    {
        $request->validate(
            ['payment_type' => 'required']
        );

        $order = Order::where('user_id', Auth::user()->id)->where('order_status', 0)->first();
        $cartItems = CartItem::where('user_id', Auth::user()->id)->get();
        $cash_receiver = null;

        switch ($request->payment_type) {
            case '1':
                $targetModel = OnlinePayment::class;
                $type = 0;
                break;
            case '2':
                $targetModel = OfflinePayment::class;
                $type = 1;
                break;
            case '3':
                $targetModel = CashPayment::class;
                $type = 2;
                $cash_receiver = $request->cash_receiver ? $request->cash_receiver : null;
                break;
            default:
                return redirect()->back()->withErrors(['error' => 'خطا']);
        }

        $paymented = $targetModel::query()->create([
            'amount' => $order->order_final_amount,
            'user_id' => auth()->user()->id,
            'pay_date' => now(),
            'cash_receiver' => $cash_receiver,
            'status' => 1,
        ]);

        $payment = Payment::query()->create(
            [
                'amount' => $order->order_final_amount,
                'user_id' => auth()->user()->id,
                'pay_date' => now(),
                'type' => $type,
                'paymentable_id' => $paymented->id,
                'paymentable_type' => $targetModel,
                'staus' => 1,
            ]
        );

        if ($request->payment_type == 1) {
            $paymentService->zarinpal($order->order_final_amount, $order, $paymented);
        }

        $order->update(
            ['order_status' => 3]
        );

        foreach ($cartItems as $cartItem) {

            OrderItem::query()->create([
                'order_id' => $order->id,
                'product_id' => $cartItem->product_id,
                'product' => $cartItem->product,
                'amazing_sale_id' => $cartItem->product->activeAmazingSales()->id ?? null,
                'amazing_sale_object' => $cartItem->product->activeAmazingSales() ?? null,
                'amazing_sale_discount_amount' => empty($cartItem->product->activeAmazingSales()) ? 0 : $cartItem->cartItemProductPrice() * ($cartItem->product->activeAmazingSales()->percentage / 100),
                'number' => $cartItem->number,
                'final_product_price' => empty($cartItem->product->activeAmazingSales()) ? $cartItem->cartItemProductPrice() : ($cartItem->cartItemProductPrice() - $cartItem->cartItemProductPrice() * ($cartItem->product->activeAmazingSales()->percentage / 100)),
                'final_total_price' => empty($cartItem->product->activeAmazingSales()) ? $cartItem->cartItemProductPrice() * ($cartItem->number) : ($cartItem->cartItemProductPrice() - $cartItem->cartItemProductPrice() * ($cartItem->product->activeAmazingSales()->percentage / 100)) * ($cartItem->number),
                'color_id' => $cartItem->color_id,
                'guarantee_id' => $cartItem->guarantee_id,
            ]);

            $cartItem->delete();
        }

        return redirect()->route('customer.home')->with('success', 'سفارش شما با موفقیت ثبت شد');

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
        $cartItems = CartItem::query()->where('user_id', Auth::user()->id)->get();

        foreach ($cartItems as $cartItem) {
            OrderItem::query()->create([
                'order_id' => $order->id,
                'product_id' => $cartItem->product_id,
                'product' => $cartItem->product,
                'amazing_sale_id' => $cartItem->product->activeAmazingSales()->id ?? null,
                'amazing_sale_object' => $cartItem->product->activeAmazingSales() ?? null,
                'amazing_sale_discount_amount' => empty($cartItem->product->activeAmazingSales()) ? 0 : $cartItem->cartItemProductPrice() * ($cartItem->product->activeAmazingSales()->percentage / 100),
                'number' => $cartItem->number,
                'final_product_price' => empty($cartItem->product->activeAmazingSales()) ? $cartItem->cartItemProductPrice() : ($cartItem->cartItemProductPrice() - $cartItem->cartItemProductPrice() * ($cartItem->product->activeAmazingSales()->percentage / 100)),
                'final_total_price' => empty($cartItem->product->activeAmazingSales()) ? $cartItem->cartItemProductPrice() * ($cartItem->number) : ($cartItem->cartItemProductPrice() - $cartItem->cartItemProductPrice() * ($cartItem->product->activeAmazingSales()->percentage / 100)) * ($cartItem->number),
                'color_id' => $cartItem->color_id,
                'guarantee_id' => $cartItem->guarantee_id,
            ]);

            $cartItem->delete();
        }
        if ($result['success']) {
            $order->update(
                ['order_status' => 3]
            );

            return redirect()->route('customer.home')->with('success', 'پرداخت شما با موفقیت انجام شد');
        } else {
            $order->update(
                ['order_status' => 2]
            );
            return redirect()->route('customer.home')->with('danger', 'سفارش شما با  خطا مواجه شد');
        }
    }
}

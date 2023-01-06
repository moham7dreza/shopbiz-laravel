<?php

namespace Modules\Payment\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Modules\Payment\Entities\Payment;
use Modules\Share\Http\Controllers\Controller;

class PaymentController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $payments = Payment::all();
        return view('Payment::admin.index', compact('payments'));
    }

    /**
     * @return Application|Factory|View
     */
    public function offline()
    {
        $payments = Payment::query()->where('paymentable_type', 'App\Models\Market\OfflinePayment')->get();
        return view('Payment::admin.index', compact('payments'));
    }

    /**
     * @return Application|Factory|View
     */
    public function online()
    {
        $payments = Payment::query()->where('paymentable_type', 'App\Models\Market\OnlinePayment')->get();
        return view('Payment::admin.index', compact('payments'));
    }

    public function cash()
    {
        $payments = Payment::query()->where('paymentable_type', 'App\Models\Market\CashPayment')->get();
        return view('Payment::admin.index', compact('payments'));
    }

    /**
     * @param Payment $payment
     * @return RedirectResponse
     */
    public function canceled(Payment $payment): RedirectResponse
    {
        $payment->status = 2;
        $payment->save();
        return redirect()->route('payment.index')->with('swal-success', 'تغییر شما با موفقیت انجام شد');
    }

    /**
     * @param Payment $payment
     * @return RedirectResponse
     */
    public function returned(Payment $payment): RedirectResponse
    {
        $payment->status = 3;
        $payment->save();
        return redirect()->route('payment.index')->with('swal-success', 'تغییر شما با موفقیت انجام شد');
    }

    /**
     * @param Payment $payment
     * @return Application|Factory|View
     */
    public function show(Payment $payment)
    {
        return view('Payment::admin.show', compact('payment'));
    }
}

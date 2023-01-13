<?php

namespace Modules\Payment\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Modules\Payment\Entities\Payment;
use Modules\Payment\Repositories\PaymentRepoEloquentInterface;
use Modules\Share\Http\Controllers\Controller;

class PaymentController extends Controller
{
    private string $redirectRoute = 'payment.index';

    private string $class = Payment::class;

    public PaymentRepoEloquentInterface $repo;

    public function __construct(PaymentRepoEloquentInterface $paymentRepoEloquent)
    {
        $this->repo = $paymentRepoEloquent;

        $this->middleware('can:permission-product-all-payments')->only(['index']);
        $this->middleware('can:permission-product-online-payments')->only(['online']);
        $this->middleware('can:permission-product-offline-payments')->only(['offline']);
        $this->middleware('can:permission-product-cash-payments')->only(['cash']);
        $this->middleware('can:permission-product-payment-cancel,
                                        permission-product-online-payment-cancel,
                                        permission-product-offline-payment-cancel,
                                        permission-product-cash-payment-cancel')->only(['canceled']);
        $this->middleware('can:permission-product-payment-return,
                                        permission-product-online-payment-return,
                                        permission-product-offline-payment-return,
                                        permission-product-cash-payment-return')->only(['returned']);
        $this->middleware('can:permission-product-payment-show,
                                        permission-product-online-payment-show,
                                        permission-product-offline-payment-show,
                                        permission-product-cash-payment-show')->only(['show']);
    }

    /**
     * @return Application|Factory|View
     */
    public function index(): Factory|View|Application
    {
        $payments = $this->repo->index()->paginate(10);
        return view('Payment::admin.index', compact('payments'));
    }

    /**
     * @return Application|Factory|View
     */
    public function offline(): View|Factory|Application
    {
        $payments = $this->repo->offline()->paginate(10);
        return view('Payment::admin.index', compact('payments'));
    }

    /**
     * @return Application|Factory|View
     */
    public function online(): View|Factory|Application
    {
        $payments = $this->repo->online()->paginate(10);
        return view('Payment::admin.index', compact('payments'));
    }

    /**
     * @return Factory|View|Application
     */
    public function cash(): Factory|View|Application
    {
        $payments = $this->repo->cash()->paginate(10);
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
    public function show(Payment $payment): View|Factory|Application
    {
        return view('Payment::admin.show', compact('payment'));
    }
}

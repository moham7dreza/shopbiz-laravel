<?php

namespace Modules\Payment\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Modules\Order\Entities\Order;
use Modules\Payment\Entities\Payment;
use Modules\Payment\Repositories\PaymentRepoEloquentInterface;
use Modules\Payment\Services\PaymentService;
use Modules\Share\Http\Controllers\Controller;
use Modules\Share\Traits\ShowMessageWithRedirectTrait;

class PaymentController extends Controller
{
    use ShowMessageWithRedirectTrait;

    /**
     * @var string
     */
    private string $redirectRoute = 'payment.index';

    /**
     * @var string
     */
    private string $class = Payment::class;

    public PaymentRepoEloquentInterface $repo;
    public PaymentService $service;

    /**
     * @param PaymentRepoEloquentInterface $paymentRepoEloquent
     * @param PaymentService $paymentService
     */
    public function __construct(PaymentRepoEloquentInterface $paymentRepoEloquent, PaymentService $paymentService)
    {
        $this->repo = $paymentRepoEloquent;
        $this->service = $paymentService;

        $this->middleware('can:permission all payments')->only(['index']);
        $this->middleware('can:permission online payments')->only(['online']);
        $this->middleware('can:permission offline payments')->only(['offline']);
        $this->middleware('can:permission cash payments')->only(['cash']);

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
        return view('Payment::admin.index', compact(['payments']));
    }

    /**
     * @return Application|Factory|View
     */
    public function offline(): View|Factory|Application
    {
        $payments = $this->repo->offline()->paginate(10);
        return view('Payment::admin.index', compact(['payments']));
    }

    /**
     * @return Application|Factory|View
     */
    public function online(): View|Factory|Application
    {
        $payments = $this->repo->online()->paginate(10);
        return view('Payment::admin.index', compact(['payments']));
    }

    /**
     * @return Factory|View|Application
     */
    public function cash(): Factory|View|Application
    {
        $payments = $this->repo->cash()->paginate(10);
        return view('Payment::admin.index', compact(['payments']));
    }

    /**
     * @param Payment $payment
     * @return RedirectResponse
     */
    public function canceled(Payment $payment): RedirectResponse
    {
        $this->service->makePaymentReturned($payment);
        return $this->showMessageWithRedirectRoute('سفارش شما با موفقیت باطل شد');
    }

    /**
     * @param Payment $payment
     * @return RedirectResponse
     */
    public function returned(Payment $payment): RedirectResponse
    {
        $this->service->makePaymentCanceled($payment);
        return $this->showMessageWithRedirectRoute('سفارش شما با موفقیت بازگردانده شد');
    }

    /**
     * @param Payment $payment
     * @return Application|Factory|View
     */
    public function show(Payment $payment): View|Factory|Application
    {
        return view('Payment::admin.show', compact(['payment']));
    }
}

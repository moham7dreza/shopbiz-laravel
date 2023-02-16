<?php

namespace Modules\Payment\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Modules\ACL\Entities\Permission;
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

        $this->middleware('can:'. Permission::PERMISSION_ALL_PAYMENTS)->only(['index']);
        $this->middleware('can:'. Permission::PERMISSION_ONLINE_PAYMENTS)->only(['online']);
        $this->middleware('can:'. Permission::PERMISSION_OFFLINE_PAYMENTS)->only(['offline']);
        $this->middleware('can:'. Permission::PERMISSION_CASH_PAYMENTS)->only(['cash']);
        $this->middleware('can:'. Permission::PERMISSION_PAYMENT_CANCEL)->only(['canceled']);
        $this->middleware('can:'. Permission::PERMISSION_PAYMENT_RETURN)->only(['returned']);
        $this->middleware('can:'. Permission::PERMISSION_PAYMENT_SHOW)->only(['show']);
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

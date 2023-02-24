<?php

namespace Modules\Payment\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Modules\ACL\Entities\Permission;
use Modules\Order\Entities\Order;
use Modules\Payment\Entities\Payment;
use Modules\Payment\Repositories\PaymentRepoEloquentInterface;
use Modules\Payment\Services\PaymentService;
use Modules\Share\Http\Controllers\Controller;
use Modules\Share\Services\ShareService;
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

        $this->middleware('can:' . Permission::PERMISSION_ALL_PAYMENTS)->only(['index']);
        $this->middleware('can:' . Permission::PERMISSION_ONLINE_PAYMENTS)->only(['online']);
        $this->middleware('can:' . Permission::PERMISSION_OFFLINE_PAYMENTS)->only(['offline']);
        $this->middleware('can:' . Permission::PERMISSION_CASH_PAYMENTS)->only(['cash']);
        $this->middleware('can:' . Permission::PERMISSION_PAYMENT_CANCEL)->only(['canceled']);
        $this->middleware('can:' . Permission::PERMISSION_PAYMENT_RETURN)->only(['returned']);
        $this->middleware('can:' . Permission::PERMISSION_PAYMENT_SHOW)->only(['show']);
    }

    /**
     * @return Application|Factory|View|RedirectResponse
     */
    public function index(): Factory|View|Application|RedirectResponse
    {
        $route = 'payment.index';
        $title = 'همه پرداخت ها';
        $payments = $this->checkForRequestsAndMakeQuery('all');
        if ($payments == 'not result found') {
            return $this->showAlertOfNotResultFound($route);
        }
        return view('Payment::admin.index', compact(['payments', 'route', 'title']));
    }

    /**
     * @return Application|Factory|View|RedirectResponse
     */
    public function offline(): View|Factory|Application|RedirectResponse
    {
        $route = 'payment.offline';
        $title = 'پرداخت های آفلاین';
        $payments = $this->checkForRequestsAndMakeQuery('offline');
        if ($payments == 'not result found') {
            return $this->showAlertOfNotResultFound($route);
        }
        return view('Payment::admin.index', compact(['payments', 'route', 'title']));
    }

    /**
     * @return Application|Factory|View|RedirectResponse
     */
    public function online(): View|Factory|Application|RedirectResponse
    {
        $route = 'payment.online';
        $title = 'پرداخت های آنلاین';
        $payments = $this->checkForRequestsAndMakeQuery('online');
        if ($payments == 'not result found') {
            return $this->showAlertOfNotResultFound($route);
        }
        return view('Payment::admin.index', compact(['payments', 'route', 'title']));
    }

    /**
     * @return Factory|View|Application|RedirectResponse
     */
    public function cash(): Factory|View|Application|RedirectResponse
    {
        $route = 'payment.cash';
        $title = 'پرداخت های در محل';
        $payments = $this->checkForRequestsAndMakeQuery('cash');
        if ($payments == 'not result found') {
            return $this->showAlertOfNotResultFound($route);
        }
        return view('Payment::admin.index', compact(['payments', 'route', 'title']));
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

    /**
     * @param $paymentType
     * @return LengthAwarePaginator|string
     */
    private function checkForRequestsAndMakeQuery($paymentType): LengthAwarePaginator|string
    {
        if (isset(request()->search)) {
            $payments = $this->repo->search(request()->search, $paymentType)->paginate(10);
            if (count($payments) > 0) {
                $this->showToastOfFetchedRecordsCount(count($payments));
            } else {
                return 'not result found';
            }
        } elseif (isset(request()->sort)) {
            $payments = $this->repo->sort(request()->sort, request()->dir, $paymentType)->paginate(10);
            if (count($payments) > 0) {
                $this->showToastOfSelectedDirection(request()->dir);
            }
            else { $this->showToastOfNotDataExists(); }
        } else {
            $paymentType = $paymentType == 'all' ? 'index' : $paymentType;
            $payments = $this->repo->$paymentType()->paginate(10);
        }
        return $payments;
    }
}

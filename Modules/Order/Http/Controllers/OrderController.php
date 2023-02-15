<?php

namespace Modules\Order\Http\Controllers;


use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Modules\Delivery\Entities\Delivery;
use Modules\Order\Entities\Order;
use Modules\Order\Repositories\OrderRepoEloquentInterface;
use Modules\Order\Services\OrderService;
use Modules\Share\Http\Controllers\Controller;
use Modules\Share\Traits\ShowMessageWithRedirectTrait;

class OrderController extends Controller
{
    use ShowMessageWithRedirectTrait;

    /**
     * @var string
     */
    private string $redirectRoute = 'order.index';

    /**
     * @var string
     */
    private string $class = Order::class;

    public OrderRepoEloquentInterface $repo;
    public OrderService $service;

    /**
     * @param OrderRepoEloquentInterface $orderRepoEloquent
     * @param OrderService $orderService
     */
    public function __construct(OrderRepoEloquentInterface $orderRepoEloquent, OrderService $orderService)
    {
        $this->repo = $orderRepoEloquent;
        $this->service = $orderService;

        $this->middleware('can:permission new orders')->only(['newOrders']);
        $this->middleware('can:permission sending orders')->only(['sending']);
        $this->middleware('can:permission canceled orders')->only(['canceled']);
        $this->middleware('can:permission all orders')->only(['all']);
        $this->middleware('can:permission unpaid orders')->only(['unpaid']);
        $this->middleware('can:permission returned orders')->only(['returned']);

        $this->middleware('can:permission order-show,
                                        permission returned-order-show,
                                        permission canceled-order-show,
                                        permission sending-order-show,
                                        permission unpaid-order-show,
                                        permission new-order-show')->only(['show']);
        $this->middleware('can:permission order-detail
                                        permission returned-order-detail,
                                        permission canceled-order-detail,
                                        permission sending-order-detail,
                                        permission unpaid-order-detail,
                                        permission new-order-detail')->only(['detail']);
        $this->middleware('can:permission order-status
                                        permission returned-order-status,
                                        permission canceled-order-status,
                                        permission sending-order-status,
                                        permission unpaid-order-status,
                                        permission new-order-status')->only(['changeOrderStatus']);
        $this->middleware('can:permission order-send-status
                                        permission returned-order-send-status,
                                        permission canceled-order-send-status,
                                        permission sending-order-send-status,
                                        permission unpaid-order-send-status,
                                        permission new-order-send-status')->only(['changeSendStatus']);
    }

    /**
     * @return Application|Factory|View|RedirectResponse
     */
    public function newOrders(): Factory|View|Application|RedirectResponse
    {
        if (isset(request()->search)) {
            $orders = $this->repo->search(request()->search, 'newOrders')->paginate(10);
            if (count($orders) > 0) {
                $this->showToastOfFetchedRecordsCount(count($orders));
            } else {
                return $this->showAlertOfNotResultFound();
            }
        } else {
            $orders = $this->repo->newOrders()->paginate(10);
        }

        $this->service->setOrderStatusToAwaitConfirm($orders);
        return view('Order::index', compact(['orders']));
    }

    /**
     * @return Application|Factory|View|RedirectResponse
     */
    public function sending(): View|Factory|Application|RedirectResponse
    {
        if (isset(request()->search)) {
            $orders = $this->repo->search(request()->search, 'sending')->paginate(10);
            if (count($orders) > 0) {
                $this->showToastOfFetchedRecordsCount(count($orders));
            } else {
                return $this->showAlertOfNotResultFound();
            }
        } else {
            $orders = $this->repo->sending()->paginate(10);
        }

        return view('Order::index', compact(['orders']));
    }

    /**
     * @return Application|Factory|View|RedirectResponse
     */
    public function unpaid(): View|Factory|Application|RedirectResponse
    {
        if (isset(request()->search)) {
            $orders = $this->repo->search(request()->search, 'unpaid')->paginate(10);
            if (count($orders) > 0) {
                $this->showToastOfFetchedRecordsCount(count($orders));
            } else {
                return $this->showAlertOfNotResultFound();
            }
        } else {
            $orders = $this->repo->unpaid()->paginate(10);
        }

        return view('Order::index', compact(['orders']));
    }

    /**
     * @return Application|Factory|View|RedirectResponse
     */
    public function canceled(): View|Factory|Application|RedirectResponse
    {
        if (isset(request()->search)) {
            $orders = $this->repo->search(request()->search, 'canceled')->paginate(10);
            if (count($orders) > 0) {
                $this->showToastOfFetchedRecordsCount(count($orders));
            } else {
                return $this->showAlertOfNotResultFound();
            }
        } else {
            $orders = $this->repo->canceled()->paginate(10);
        }

        return view('Order::index', compact(['orders']));
    }

    /**
     * @return Application|Factory|View|RedirectResponse
     */
    public function returned(): View|Factory|Application|RedirectResponse
    {
        if (isset(request()->search)) {
            $orders = $this->repo->search(request()->search, 'returned')->paginate(10);
            if (count($orders) > 0) {
                $this->showToastOfFetchedRecordsCount(count($orders));
            } else {
                return $this->showAlertOfNotResultFound();
            }
        } else {
            $orders = $this->repo->returned()->paginate(10);
        }

        return view('Order::index', compact(['orders']));
    }

    /**
     * @return Application|Factory|View|RedirectResponse
     */
    public function all(): View|Factory|Application|RedirectResponse
    {
        if (isset(request()->search)) {
            $orders = $this->repo->search(request()->search, 'all')->paginate(10);
            if (count($orders) > 0) {
                $this->showToastOfFetchedRecordsCount(count($orders));
            } else {
                return $this->showAlertOfNotResultFound();
            }
        } else {
            $orders = $this->repo->index()->paginate(10);
        }

        return view('Order::index', compact(['orders']));
    }

    /**
     * @param Order $order
     * @return Application|Factory|View
     */
    public function show(Order $order): View|Factory|Application
    {
        return view('Order::show', compact(['order']));
    }

    /**
     * @param Order $order
     * @return Application|Factory|View
     */
    public function detail(Order $order): View|Factory|Application
    {
        return view('Order::detail', compact(['order']));
    }

    /**
     * @param Order $order
     * @return RedirectResponse
     */
    public function changeSendStatus(Order $order): RedirectResponse
    {
        $this->service->changeSendStatus($order);
        return $this->showMessageWithRedirectRoute('وضعیت ارسال کالا با موفقیت تغییر کرد.');
    }

    /**
     * @param Order $order
     * @return RedirectResponse
     */
    public function changeOrderStatus(Order $order): RedirectResponse
    {
        $this->service->changeOrderStatus($order);
        return $this->showMessageWithRedirectRoute('وضعیت سفارش با موفقیت تغییر کرد.');
    }

    /**
     * @param Order $order
     * @return RedirectResponse
     */
    public function cancelOrder(Order $order): RedirectResponse
    {
        $this->service->makeOrderStatusCanceled($order);
        return $this->showMessageWithRedirectRoute('وضعیت سفارش به باطل شده تغییر کرد.');
    }
}

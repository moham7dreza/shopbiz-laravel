<?php

namespace Modules\Order\Http\Controllers;


use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Modules\Order\Entities\Order;
use Modules\Order\Repositories\OrderRepoEloquentInterface;
use Modules\Share\Http\Controllers\Controller;

class OrderController extends Controller
{
    private string $redirectRoute = 'order.index';

    private string $class = Order::class;

    public OrderRepoEloquentInterface $repo;

    public function __construct(OrderRepoEloquentInterface $orderRepoEloquent)
    {
        $this->repo = $orderRepoEloquent;

        $this->middleware('can:permission-product-new-orders')->only(['newOrders']);
        $this->middleware('can:permission-product-sending-orders')->only(['sending']);
        $this->middleware('can:permission-product-canceled-orders')->only(['canceled']);
        $this->middleware('can:permission-product-all-orders')->only(['all']);
        $this->middleware('can:permission-product-unpaid-orders')->only(['unpaid']);
        $this->middleware('can:permission-product-returned-orders')->only(['returned']);
        $this->middleware('can:permission-product-order-show,
                                        permission-product-returned-order-show,
                                        permission-product-canceled-order-show,
                                        permission-product-sending-order-show,
                                        permission-product-unpaid-order-show,
                                        permission-product-new-order-show')->only(['show']);
        $this->middleware('can:permission-product-order-detail
                                        permission-product-returned-order-detail,
                                        permission-product-canceled-order-detail,
                                        permission-product-sending-order-detail,
                                        permission-product-unpaid-order-detail,
                                        permission-product-new-order-detail')->only(['detail']);
        $this->middleware('can:permission-product-order-status
                                        permission-product-returned-order-status,
                                        permission-product-canceled-order-status,
                                        permission-product-sending-order-status,
                                        permission-product-unpaid-order-status,
                                        permission-product-new-order-status')->only(['changeOrderStatus']);
        $this->middleware('can:permission-product-order-send-status
                                        permission-product-returned-order-send-status,
                                        permission-product-canceled-order-send-status,
                                        permission-product-sending-order-send-status,
                                        permission-product-unpaid-order-send-status,
                                        permission-product-new-order-send-status')->only(['changeSendStatus']);
    }

    /**
     * @return Application|Factory|View
     */
    public function newOrders()
    {
        $orders = Order::query()->where('order_status', 0)->get();
        foreach ($orders as $order) {
            $order->order_status = 1;
            $result = $order->save();
        }
        return view('Order::index', compact('orders'));
    }

    /**
     * @return Application|Factory|View
     */
    public function sending()
    {
        $orders = Order::query()->where('delivery_status', 1)->get();
        return view('Order::index', compact('orders'));
    }

    /**
     * @return Application|Factory|View
     */
    public function unpaid()
    {
        $orders = Order::query()->where('payment_status', 0)->get();
        return view('Order::index', compact('orders'));
    }

    /**
     * @return Application|Factory|View
     */
    public function canceled()
    {
        $orders = Order::query()->where('order_status', 4)->get();
        return view('Order::index', compact('orders'));
    }

    /**
     * @return Application|Factory|View
     */
    public function returned()
    {
        $orders = Order::query()->where('order_status', 5)->get();
        return view('Order::index', compact('orders'));
    }

    /**
     * @return Application|Factory|View
     */
    public function all()
    {
        $orders = Order::all();
        return view('Order::index', compact('orders'));
    }

    /**
     * @param Order $order
     * @return Application|Factory|View
     */
    public function show(Order $order)
    {
        return view('Order::show', compact('order'));
    }

    /**
     * @param Order $order
     * @return Application|Factory|View
     */
    public function detail(Order $order)
    {
        return view('Order::detail', compact('order'));
    }

    /**
     * @param Order $order
     * @return RedirectResponse
     */
    public function changeSendStatus(Order $order): RedirectResponse
    {
        switch ($order->delivery_status){
            case 0:
                $order->delivery_status = 1;
                break;
                case 1:
                    $order->delivery_status = 2;
                    break;
                    case 2:
                        $order->delivery_status = 3;
                        break;
                        default :
                        $order->delivery_status = 0;
        }
        $order->save();
        return back();
    }

    /**
     * @param Order $order
     * @return RedirectResponse
     */
    public function changeOrderStatus(Order $order): RedirectResponse
    {
        switch ($order->order_status){
            case 1:
                $order->order_status = 2;
                break;
                case 2:
                    $order->order_status = 3;
                    break;
                    case 3:
                        $order->order_status = 4;
                        break;
                         case 4:
                        $order->order_status = 5;
                        break;
                         case 5:
                        $order->order_status = 6;
                        break;
                        default :
                        $order->order_status = 1;
        }
        $order->save();
        return back();
    }

    /**
     * @param Order $order
     * @return RedirectResponse
     */
    public function cancelOrder(Order $order): RedirectResponse
    {
        $order->order_status = 4;
        $order->save();
        return back();
    }
}

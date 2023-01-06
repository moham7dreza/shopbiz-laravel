<?php

namespace Modules\Order\Http\Controllers;


use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Modules\Order\Entities\Order;
use Modules\Share\Http\Controllers\Controller;

class OrderController extends Controller
{
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

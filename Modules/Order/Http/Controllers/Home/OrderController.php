<?php

namespace Modules\Order\Http\Controllers\Home;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Modules\Order\Entities\Order;
use Modules\Payment\Entities\Payment;
use Modules\Share\Http\Controllers\Controller;

class OrderController extends Controller
{
    /**
     * @param Order $order
     * @param Payment $payment
     * @return Application|Factory|View
     */
    public function index(Order $order, Payment $payment): View|Factory|Application
    {
        return view('Order::home.order-received', compact(['order', 'payment']));
    }
}

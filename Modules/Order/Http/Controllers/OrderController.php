<?php

namespace Modules\Order\Http\Controllers;

use Modules\Share\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function index()
    {
        dd(1);
        return view('Order::index');
    }
}

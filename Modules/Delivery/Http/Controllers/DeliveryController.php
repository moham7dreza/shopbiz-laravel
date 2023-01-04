<?php

namespace Modules\Delivery\Http\Controllers;

use Modules\Share\Http\Controllers\Controller;

class DeliveryController extends Controller
{
    public function index()
    {
        dd(1);
        return view('Delivery::index');
    }
}

<?php

namespace Modules\Payment\Http\Controllers;

use Modules\Share\Http\Controllers\Controller;

class PaymentController extends Controller
{
    public function index()
    {
        dd(1);
        return view('Payment::index');
    }
}

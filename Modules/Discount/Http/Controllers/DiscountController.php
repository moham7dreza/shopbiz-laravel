<?php

namespace Modules\Discount\Http\Controllers;

use Modules\Share\Http\Controllers\Controller;

class DiscountController extends Controller
{
    public function index()
    {
        dd(1);
        return view('Discount::index');
    }
}

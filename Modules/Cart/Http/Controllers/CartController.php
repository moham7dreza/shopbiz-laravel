<?php

namespace Modules\Cart\Http\Controllers;

use Modules\Share\Http\Controllers\Controller;

class CartController extends Controller
{
    public function index()
    {
        dd(1);
        return view('Banner::index');
    }
}

<?php

namespace Modules\User\Http\Controllers\Home\Profile;


use Modules\Share\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function index()
    {
        if(isset(request()->type))
        {
            $orders = auth()->user()->orders()->where('order_status', request()->type)->orderBy('id', 'desc')->get();

        }
        else{
            $orders = auth()->user()->orders()->orderBy('id', 'desc')->get();
        }
        return view('User::home.profile.orders', compact('orders'));
    }
}

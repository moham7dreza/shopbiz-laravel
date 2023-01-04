<?php

namespace Modules\Home\Http\Controllers;

use Modules\Share\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        dd(1);
        return view('Home::index');
    }
}

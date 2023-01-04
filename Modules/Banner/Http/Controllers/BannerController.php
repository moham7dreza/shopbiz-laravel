<?php

namespace Modules\Banner\Http\Controllers;

use Modules\Share\Http\Controllers\Controller;

class BannerController extends Controller
{
    public function index()
    {
        dd(1);
        return view('Banner::index');
    }
}

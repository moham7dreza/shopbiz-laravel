<?php

namespace Modules\Brand\Http\Controllers;

use Modules\Share\Http\Controllers\Controller;

class BrandController extends Controller
{
    public function index()
    {
        dd(1);
        return view('Brand::index');
    }
}

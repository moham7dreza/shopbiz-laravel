<?php

namespace Modules\Page\Http\Controllers;

use Modules\Share\Http\Controllers\Controller;

class PageController extends Controller
{
    public function index()
    {
        dd(1);
        return view('Page::index');
    }
}

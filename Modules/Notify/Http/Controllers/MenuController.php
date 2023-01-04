<?php

namespace Modules\Menu\Http\Controllers;

use Modules\Share\Http\Controllers\Controller;

class MenuController extends Controller
{
    public function index()
    {
        dd(1);
        return view('Menu::index');
    }
}

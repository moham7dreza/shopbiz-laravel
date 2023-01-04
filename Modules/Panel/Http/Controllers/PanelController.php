<?php

namespace Modules\Panel\Http\Controllers;

use Modules\Share\Http\Controllers\Controller;

class PanelController extends Controller
{

    public function index()
    {
        dd(1);
        return view('Panel::index');
    }

    public function __invoke()
    {
//        $this->authorize('manage', Panel::class);
        return view('Panel::index');
    }
}

<?php

namespace Modules\Panal\Http\Controllers;

use Modules\Share\Http\Controllers\Controller;

class PanelController extends Controller
{

    public function index()
    {
        return view('Panel::index');
    }

    public function __invoke()
    {
        dd(1);
//        $this->authorize('manage', Panel::class);
        return view('Panel::index');
    }
}

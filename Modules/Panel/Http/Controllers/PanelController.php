<?php

namespace Modules\Panel\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Modules\Panel\Repositories\PanelRepo;
use Modules\Share\Http\Controllers\Controller;

class PanelController extends Controller
{
    /**
     *
     */
    public function __construct()
    {
        $this->middleware('can:permission-admin-panel');
    }

    /**
     * @param PanelRepo $panelRepo
     * @return Application|Factory|View
     */
    public function __invoke(PanelRepo $panelRepo): View|Factory|Application
    {
//        $this->authorize('manage', Panel::class);
        return view('Panel::index', compact(['panelRepo']));
    }
}

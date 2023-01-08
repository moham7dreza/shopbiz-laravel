<?php

namespace Modules\Panel\Http\Controllers;

use Modules\Panel\Repositories\PanelRepo;
use Modules\Share\Http\Controllers\Controller;

class PanelController extends Controller
{
    public function __invoke(PanelRepo $panelRepo)
    {
//        $this->authorize('manage', Panel::class);
        return view('Panel::index', compact(['panelRepo']));
    }
}

<?php

namespace Modules\Panel\Http\Controllers;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Gate;
use Modules\ACL\Entities\Permission;
use Modules\ACL\Entities\Role;
use Modules\Panel\Entities\Panel;
use Modules\Panel\Repositories\PanelRepo;
use Modules\Share\Http\Controllers\Controller;

class PanelController extends Controller
{
    /**
     *
     */
    public function __construct()
    {
//        $role = Role::query()->first();
//        $per = Permission::query()->where('name', Permission::PERMISSION_SUPER_ADMIN)->first();
//        dd(auth()->user()->role('role super admin')->first());
//        dd(auth()->user()->hasPermissionTo(Permission::PERMISSION_SUPER_ADMIN));
//        dd(auth()->user()->hasAnyRole(Permission::query()->where('name', Permission::PERMISSION_ADMIN_PANEL)->first()->roles));
//        dd(Permission::query()->where('name', Permission::PERMISSION_SUPER_ADMIN)->first()->roles);
        $this->middleware('can:' . Permission::PERMISSION_ADMIN_PANEL);
    }

    /**
     * @param PanelRepo $panelRepo
     * @return Application|Factory|View
     */
    public function __invoke(PanelRepo $panelRepo): View|Factory|Application
    {
//        $this->authorize('manage', Panel::class);
        return view('Panel::dashboards.index', compact(['panelRepo']));
    }

    /**
     * @param PanelRepo $panelRepo
     * @return Application|Factory|View
     */
    public function logs(PanelRepo $panelRepo): View|Factory|Application
    {
//        $this->authorize('manage', Panel::class);
        return view('Panel::dashboards.logs', compact(['panelRepo']));
    }

    /**
     * @param PanelRepo $panelRepo
     * @return Application|Factory|View
     */
    public function sales(PanelRepo $panelRepo): View|Factory|Application
    {
//        $this->authorize('manage', Panel::class);
        return view('Panel::dashboards.sales', compact(['panelRepo']));
    }
}

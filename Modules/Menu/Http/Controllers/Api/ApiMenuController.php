<?php

namespace Modules\Menu\Http\Controllers\Api;

use Modules\Menu\Http\Resources\MenuResource;
use Modules\Menu\Repositories\MenuRepoEloquentInterface;
use Modules\Menu\Services\MenuService;
use Modules\Share\Http\Controllers\Controller;

class ApiMenuController extends Controller
{
    public MenuRepoEloquentInterface $repo;
    public MenuService $service;

    /**
     * @param MenuRepoEloquentInterface $menuRepoEloquent
     * @param MenuService $menuService
     */
    public function __construct(MenuRepoEloquentInterface $menuRepoEloquent, MenuService $menuService)
    {
        $this->repo = $menuRepoEloquent;
        $this->service = $menuService;
    }

    /**
     * @return MenuResource
     */
    public function index(): MenuResource
    {
        $menus = $this->repo->index()->paginate(10);
        return new MenuResource($menus);
    }
}

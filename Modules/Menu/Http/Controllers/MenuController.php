<?php

namespace Modules\Menu\Http\Controllers;


use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Modules\Menu\Entities\Menu;
use Modules\Menu\Http\Requests\MenuRequest;
use Modules\Menu\Repositories\MenuRepoEloquentInterface;
use Modules\Menu\Services\MenuService;
use Modules\Share\Http\Controllers\Controller;
use Modules\Share\Services\ShareService;
use Modules\Share\Traits\ShowMessageWithRedirectTrait;

class MenuController extends Controller
{
    use ShowMessageWithRedirectTrait;

    /**
     * @var string
     */
    private string $redirectRoute = 'menu.index';

    /**
     * @var string
     */
    private string $class = Menu::class;

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

        $this->middleware('can:permission-menus')->only(['index']);
        $this->middleware('can:permission-menu-create')->only(['create', 'store']);
        $this->middleware('can:permission-menu-edit')->only(['edit', 'update']);
        $this->middleware('can:permission-menu-delete')->only(['destroy']);
        $this->middleware('can:permission-menu-status')->only(['status']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): View|Factory|Application
    {
        $menus = $this->repo->index()->paginate(10);
        return view('Menu::index', compact(['menus']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(): View|Factory|Application
    {
        $menus = $this->repo->getParentMenus()->get();
        return view('Menu::create', compact(['menus']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param MenuRequest $request
     * @return RedirectResponse
     */
    public function store(MenuRequest $request): RedirectResponse
    {
        $this->service->store($request);
        return $this->showMessageWithRedirect('منوی جدید شما با موفقیت ثبت شد');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show(int $id): Response
    {
        abort(403);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Menu $menu
     * @return Application|Factory|View
     */
    public function edit(Menu $menu): View|Factory|Application
    {
        $parent_menus = $this->repo->getParentMenus()->get()->except($menu->id);
        return view('Menu::edit', compact(['menu', 'parent_menus']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param MenuRequest $request
     * @param Menu $menu
     * @return RedirectResponse
     */
    public function update(MenuRequest $request, Menu $menu): RedirectResponse
    {
        $this->service->update($request, $menu);
        return $this->showMessageWithRedirect('منوی شما با موفقیت ویرایش شد');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Menu $menu
     * @return RedirectResponse
     */
    public function destroy(Menu $menu): RedirectResponse
    {
        $result = $menu->delete();
        return $this->showMessageWithRedirect('منو شما با موفقیت حذف شد');
    }


    /**
     * @param Menu $menu
     * @return JsonResponse
     */
    public function status(Menu $menu): JsonResponse
    {
        return ShareService::changeStatus($menu);
    }
}

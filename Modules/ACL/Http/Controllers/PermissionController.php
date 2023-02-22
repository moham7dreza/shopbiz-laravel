<?php

namespace Modules\ACL\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Modules\ACL\Entities\Permission;
use Modules\ACL\Http\Requests\PermissionRequest;
use Modules\ACL\Repositories\RolePermissionRepoEloquentInterface;
use Modules\ACL\Services\RolePermissionService;
use Modules\Share\Http\Controllers\Controller;
use Modules\Share\Services\ShareService;
use Modules\Share\Traits\ShowMessageWithRedirectTrait;

class PermissionController extends Controller
{
    use ShowMessageWithRedirectTrait;

    /**
     * @var string
     */
    private string $redirectRoute = 'permission.index';

    /**
     * @var string
     */
    private string $class = Permission::class;

    public RolePermissionRepoEloquentInterface $repo;
    public RolePermissionService $service;

    /**
     * @param RolePermissionService $rolePermissionService
     * @param RolePermissionRepoEloquentInterface $rolePermissionRepo
     */
    public function __construct(RolePermissionService $rolePermissionService, RolePermissionRepoEloquentInterface $rolePermissionRepo)
    {
        $this->repo = $rolePermissionRepo;
        $this->service = $rolePermissionService;

        $this->middleware('can:'. Permission::PERMISSIONS)->only(['index']);
        $this->middleware('can:'. Permission::PERMISSION_CREATE)->only(['create', 'store']);
        $this->middleware('can:'. Permission::PERMISSION_EDIT)->only(['edit', 'update']);
        $this->middleware('can:'. Permission::PERMISSION_DELETE)->only(['destroy']);
        $this->middleware('can:'. Permission::PERMISSION_STATUS)->only(['status']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return View|Factory|Application|RedirectResponse
     */
    public function index(): View|Factory|Application|RedirectResponse
    {
        if (isset(request()->search)) {
            $permissions = $this->repo->searchPermission(request()->search)->paginate(10);
            if (count($permissions) > 0) {
                $this->showToastOfFetchedRecordsCount(count($permissions));
            } else {
                return $this->showAlertOfNotResultFound();
            }
        } elseif (isset(request()->sort)) {
            $permissions = $this->repo->permissions()->orderBy(request()->sort, request()->dir)->paginate(10);
        }
        else {
            $permissions = $this->repo->permissions()->paginate(10);
        }
        return view('ACL::permission.index', compact(['permissions']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(): Factory|View|Application
    {
        return view('ACL::permission.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PermissionRequest $request
     * @return RedirectResponse
     */
    public function store(PermissionRequest $request): RedirectResponse
    {
        $this->service->permissionStore($request);
        return $this->showMessageWithRedirectRoute('دسترسی جدید با موفقیت ثبت شد');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort(403);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Permission $permission
     * @return Application|Factory|View
     */
    public function edit(Permission $permission): View|Factory|Application
    {
        return view('ACL::permission.edit', compact(['permission']));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param PermissionRequest $request
     * @param Permission $permission
     * @return RedirectResponse
     */
    public function update(PermissionRequest $request, Permission $permission): RedirectResponse
    {
        $this->service->permissionUpdate($request, $permission);
        return $this->showMessageWithRedirectRoute('دسترسی شما با موفقیت ویرایش شد');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Permission $permission
     * @return RedirectResponse
     */
    public function destroy(Permission $permission): RedirectResponse
    {
        $result = $permission->delete();
        return $this->showMessageWithRedirectRoute('دسترسی شما با موفقیت حذف شد');
    }

    /**
     * @param Permission $permission
     * @return JsonResponse
     */
    public function status(Permission $permission): JsonResponse
    {
        return ShareService::changeStatus($permission);
    }
}

<?php

namespace Modules\ACL\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Modules\ACL\Entities\Role;
use Modules\ACL\Http\Requests\RoleRequest;
use Modules\ACL\Repositories\RolePermissionRepoEloquentInterface;
use Modules\ACL\Services\RolePermissionService;
use Modules\Share\Http\Controllers\Controller;
use Modules\Share\Services\ShareService;
use Modules\Share\Traits\ShowMessageWithRedirectTrait;

class RoleController extends Controller
{
    use ShowMessageWithRedirectTrait;

    /**
     * @var string
     */
    private string $redirectRoute = 'role.index';

    /**
     * @var string
     */
    private string $class = Role::class;

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

        $this->middleware('can:permission user roles')->only(['index']);
        $this->middleware('can:permission user role create')->only(['create', 'store']);
        $this->middleware('can:permission user role edit')->only(['edit', 'update']);
        $this->middleware('can:permission user role delete')->only(['destroy']);
        $this->middleware('can:permission user role status')->only(['status']);
        $this->middleware('can:permission user role permissions')->only(['permissionForm', 'permissionUpdate']);
        $this->middleware('can:permission user permissions import')->only(['permissionImport']);
        $this->middleware('can:permission user permissions export')->only(['permissionExport']);

    }

    /**
     * Display a listing of the resource.
     *
     * @return View|Factory|Application|RedirectResponse
     */
    public function index(): View|Factory|Application|RedirectResponse
    {
        if (isset(request()->search)) {
            $roles = $this->repo->search(request()->search)->paginate(10);
            if (count($roles) > 0) {
                $this->showToastOfFetchedRecordsCount(count($roles));
            } else {
                return $this->showAlertOfNotResultFound();
            }
        } else {
            $roles = $this->repo->index()->paginate(10);
        }
        return view('ACL::role.index', compact(['roles']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(): View|Factory|Application
    {
        return view('ACL::role.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param RoleRequest $request
     * @return RedirectResponse
     */
    public function store(RoleRequest $request): RedirectResponse
    {
        $this->service->store($request);
        return $this->showMessageWithRedirectRoute('نقش جدید با موفقیت ثبت شد');
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
     * @param Role $role
     * @return Application|Factory|View
     */
    public function edit(Role $role): View|Factory|Application
    {
        return view('ACL::role.edit', compact(['role']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param RoleRequest $request
     * @param Role $role
     * @return RedirectResponse
     */
    public function update(RoleRequest $request, Role $role): RedirectResponse
    {
        $this->service->update($request, $role);
        return $this->showMessageWithRedirectRoute('نقش شما با موفقیت ویرایش شد');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Role $role
     * @return RedirectResponse
     */
    public function destroy(Role $role): RedirectResponse
    {
        $result = $role->delete();
        return $this->showMessageWithRedirectRoute('نقش شما با موفقیت حذف شد');
    }


    /**
     * @param Role $role
     * @return Application|Factory|View|RedirectResponse
     */
    public function permissionForm(Role $role): Factory|View|Application|RedirectResponse
    {
        $permissions = $this->repo->getAllPermissions();
        if ($permissions->count() > 0) {
            return view('ACL::role.set-permission', compact(['role', 'permissions']));
        }
        return $this->showMessageWithRedirectRoute(msg: 'برای تخصیص نقش ابتدا باید سطوح دسترسی تعریف کنید.', title: 'خطا', status: 'error');
    }


    /**
     * @param RoleRequest $request
     * @param Role $role
     * @return RedirectResponse
     */
    public function permissionUpdate(RoleRequest $request, Role $role): RedirectResponse
    {
//        $this->service->rolePermissionsUpdate($request, $role);
        $role->syncPermissions($request->permissions);
        return $this->showMessageWithRedirectRoute('سطوح دسترسی نقش با موفقیت بروز رسانی شد');
    }

    /**
     * @param Role $role
     * @return JsonResponse
     */
    public function status(Role $role): JsonResponse
    {
        return ShareService::changeStatus($role);
    }
}

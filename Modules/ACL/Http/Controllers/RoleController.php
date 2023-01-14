<?php

namespace Modules\ACL\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Modules\ACL\Entities\Permission;
use Modules\ACL\Entities\Role;
use Modules\ACL\Http\Requests\RoleRequest;
use Modules\ACL\Repositories\RolePermissionRepoEloquentInterface;
use Modules\ACL\Services\RolePermissionService;
use Modules\Share\Http\Controllers\Controller;

class RoleController extends Controller
{
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

        $this->middleware('can:permission-user-roles')->only(['index']);
        $this->middleware('can:permission-user-role-create')->only(['create', 'store']);
        $this->middleware('can:permission-user-role-edit')->only(['edit', 'update']);
        $this->middleware('can:permission-user-role-delete')->only(['destroy']);
        $this->middleware('can:permission-user-role-status')->only(['status']);
        $this->middleware('can:permission-user-role-permissions')->only(['permissionForm', 'permissionUpdate']);
        $this->middleware('can:permission-user-permissions-import')->only(['permissionImport']);
        $this->middleware('can:permission-user-permissions-export')->only(['permissionExport']);

    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): View|Factory|Application
    {
        $roles = $this->repo->index()->paginate(10);
        return view('ACL::role.index', compact(['roles']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(): View|Factory|Application
    {
        $permissions = $this->repo->getAllPermissions();
        return view('ACL::role.create', compact(['permissions']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param RoleRequest $request
     * @return RedirectResponse
     */
    public function store(RoleRequest $request): RedirectResponse
    {
        $inputs = $request->all();
        $role = Role::query()->create($inputs);
        $inputs['permissions'] = $inputs['permissions'] ?? [];
        $role->permissions()->sync($inputs['permissions']);
        return redirect()->route('role.index')->with('swal-success', 'نقش جدید با موفقیت ثبت شد');
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
        $inputs = $request->all();
        $role->update($inputs);
        return redirect()->route('role.index')->with('swal-success', 'نقش شما با موفقیت ویرایش شد');
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
        return redirect()->route('role.index')->with('swal-success', 'نقش شما با موفقیت حذف شد');
    }


    /**
     * @param Role $role
     * @return Application|Factory|View
     */
    public function permissionForm(Role $role): Factory|View|Application
    {
        $permissions =  $this->repo->getAllPermissions();
        return view('ACL::role.set-permission', compact('role', 'permissions'));

    }


    /**
     * @param RoleRequest $request
     * @param Role $role
     * @return RedirectResponse
     */
    public function permissionUpdate(RoleRequest $request, Role $role): RedirectResponse
    {
        $inputs = $request->all();
        $inputs['permissions'] = $inputs['permissions'] ?? [];
        $role->permissions()->sync($inputs['permissions']);
        return redirect()->route('role.index')->with('swal-success', 'نقش جدید با موفقیت ویرایش شد');
    }

    /**
     * @param Role $role
     * @return JsonResponse
     */
    public function status(Role $role): JsonResponse
    {
        $role->status = $role->status == 0 ? 1 : 0;
        $result = $role->save();
        if ($result) {
            if ($role->status == 0) {
                return response()->json(['status' => true, 'checked' => false]);
            } else {
                return response()->json(['status' => true, 'checked' => true]);
            }
        } else {
            return response()->json(['status' => false]);
        }
    }
}

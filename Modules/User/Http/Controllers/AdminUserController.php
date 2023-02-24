<?php

namespace Modules\User\Http\Controllers;


use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\ACL\Entities\Permission;
use Modules\ACL\Repositories\RolePermissionRepoEloquentInterface;
use Modules\Share\Http\Controllers\Controller;
use Modules\Share\Services\Image\ImageService;
use Modules\Share\Services\ShareService;
use Modules\Share\Traits\ShowMessageWithRedirectTrait;
use Modules\User\Entities\User;
use Modules\User\Http\Requests\AdminUserRequest;
use Modules\User\Http\Requests\UserPermissionsRequest;
use Modules\User\Http\Requests\UserRolesRequest;
use Modules\User\Repositories\UserRepoEloquentInterface;
use Modules\User\Services\UserService;

class AdminUserController extends Controller
{
    use ShowMessageWithRedirectTrait;

    /**
     * @var string
     */
    private string $redirectRoute = 'adminUser.index';

    /**
     * @var string
     */
    private string $class = User::class;

    public UserRepoEloquentInterface $repo;
    public UserService $service;

    /**
     * @param UserRepoEloquentInterface $userRepoEloquent
     * @param UserService $userService
     */
    public function __construct(UserRepoEloquentInterface $userRepoEloquent, UserService $userService)
    {
        $this->repo = $userRepoEloquent;
        $this->service = $userService;

        $this->middleware('can:' . Permission::PERMISSION_ADMIN_USERS)->only(['index']);
        $this->middleware('can:' . Permission::PERMISSION_ADMIN_USER_CREATE)->only(['create', 'store']);
        $this->middleware('can:' . Permission::PERMISSION_ADMIN_USER_EDIT)->only(['edit', 'update']);
        $this->middleware('can:' . Permission::PERMISSION_ADMIN_USER_DELETE)->only(['destroy']);
        $this->middleware('can:' . Permission::PERMISSION_ADMIN_USER_STATUS)->only(['status']);
        $this->middleware('can:' . Permission::PERMISSION_ADMIN_USER_ACTIVATION)->only(['activation']);
        $this->middleware('can:' . Permission::PERMISSION_ADMIN_USER_ROLES)->only(['roleForm', 'roleUpdate']);
        $this->middleware('can:' . Permission::PERMISSION_ADMIN_USER_PERMISSIONS)->only(['permissions', 'permissionsStore']);
    }


    /**
     * @return Application|Factory|View|RedirectResponse
     */
    public function index(): View|Factory|Application|RedirectResponse
    {
        if (isset(request()->search)) {
            $adminUsers = $this->repo->search(request()->search)->paginate(10);
            if (count($adminUsers) > 0) {
                $this->showToastOfFetchedRecordsCount(count($adminUsers));
            } else {
                return $this->showAlertOfNotResultFound();
            }
        } elseif (isset(request()->sort)) {
            $adminUsers = $this->repo->sort(request()->sort, request()->dir)->paginate(10);
            if (count($adminUsers) > 0) {
                $this->showToastOfSelectedDirection(request()->dir);
            }
            $this->showToastOfNotDataExists();
        } else {
            $adminUsers = $this->repo->adminUsers()->paginate(10);
        }

        return view('User::admin-user.index', compact(['adminUsers']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(): View|Factory|Application
    {
        return view('User::admin-user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AdminUserRequest $request
     * @return RedirectResponse
     */
    public function store(AdminUserRequest $request): \Illuminate\Http\RedirectResponse
    {
        $result = $this->service->store($request, User::TYPE_ADMIN);
        if ($result == 'upload failed') {
            return $this->showMessageWithRedirectRoute('آپلود تصویر با خطا مواجه شد', 'خطا', status: 'error');
        }
        return $this->showMessageWithRedirectRoute('ادمین جدید با موفقیت ثبت شد');
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
     * @param User $adminUser
     * @return Application|Factory|View
     */
    public function edit(User $adminUser): View|Factory|Application
    {
        return view('User::admin-user.edit', compact(['adminUser']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param AdminUserRequest $request
     * @param User $adminUser
     * @return RedirectResponse
     */
    public function update(AdminUserRequest $request, User $adminUser): RedirectResponse
    {
        $result = $this->service->update($request, $adminUser);
        if ($result == 'upload failed') {
            return $this->showMessageWithRedirectRoute('آپلود تصویر با خطا مواجه شد', 'خطا', status: 'error');
        }
        return $this->showMessageWithRedirectRoute('ادمین سایت شما با موفقیت ویرایش شد');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $adminUser
     * @return RedirectResponse
     */
    public function destroy(User $adminUser): RedirectResponse
    {
        $result = $adminUser->delete();
        return $this->showMessageWithRedirectRoute('ادمین شما با موفقیت حذف شد');
    }

    /**
     * @param User $user
     * @return JsonResponse
     */
    public function status(User $user): JsonResponse
    {
        return ShareService::changeStatus($user);
    }

    /**
     * @param User $user
     * @return JsonResponse
     */
    public function activation(User $user): JsonResponse
    {
        $user->activation_date = $user->activation == User::ACTIVATE ? null : now();
        return ShareService::ajaxChangeModelSpecialField($user, 'activation');
    }

    /**
     * @param User $admin
     * @param RolePermissionRepoEloquentInterface $rolePermissionRepo
     * @return Application|Factory|View
     */
    public function roles(User $admin, RolePermissionRepoEloquentInterface $rolePermissionRepo): View|Factory|Application
    {
        $roles = $rolePermissionRepo->index()->get();
        return view('User::admin-user.roles', compact(['admin', 'roles']));
    }

    /**
     * @param UserRolesRequest $request
     * @param User $admin
     * @param RolePermissionRepoEloquentInterface $roleRepo
     * @return RedirectResponse
     */
    public function rolesStore(UserRolesRequest $request, User $admin, RolePermissionRepoEloquentInterface $roleRepo): RedirectResponse
    {
//        if (is_null($request->roles)) {
//            foreach ($admin->roles as $role) {
//                $admin->permissions()->detach($role->permissions);
//            }
////            $admin->roles()->sync($request->roles);
//            $admin->syncRoles($request->roles);
//        } else {
////            $admin->roles()->sync($request->roles);
//            $admin->syncRoles($request->roles);
//            foreach ($request->roles as $single_role) {
//                $role = $roleRepo->findById($single_role);
//                $admin->permissions()->attach($role->permissions);
//            }
//        }
        $admin->syncRoles($request->roles);
        return $this->showMessageWithRedirectRoute('نقش با موفقیت ویرایش شد');
    }


    /**
     * @param User $admin
     * @param RolePermissionRepoEloquentInterface $rolePermissionRepo
     * @return Application|Factory|View
     */
    public function permissions(User $admin, RolePermissionRepoEloquentInterface $rolePermissionRepo): View|Factory|Application
    {
        $permissions = $rolePermissionRepo->permissions()->get();
        return view('User::admin-user.permissions', compact(['admin', 'permissions']));
    }

    /**
     * @param UserPermissionsRequest $request
     * @param User $admin
     * @return RedirectResponse
     */
    public function permissionsStore(UserPermissionsRequest $request, User $admin): RedirectResponse
    {
//        $admin->permissions()->sync($request->permissions);
        $admin->syncPermissions($request->permissions);
        return $this->showMessageWithRedirectRoute('سطح دسترسی با موفقیت ویرایش شد');
    }
}

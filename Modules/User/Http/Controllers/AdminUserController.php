<?php

namespace Modules\User\Http\Controllers;


use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Modules\ACL\Entities\Permission;
use Modules\ACL\Entities\Role;
use Modules\Share\Http\Controllers\Controller;
use Modules\Share\Http\Services\Image\ImageService;
use Modules\User\Entities\User;
use Modules\User\Http\Requests\AdminUserRequest;
use Modules\User\Repositories\UserRepoEloquentInterface;
use Modules\User\Services\UserService;

class AdminUserController extends Controller
{

    private string $redirectRoute = 'adminUser.index';

    private string $class = User::class;

    public UserRepoEloquentInterface $repo;
    public UserService $service;

    public function __construct(UserRepoEloquentInterface $userRepoEloquent, UserService $userService)
    {
        $this->repo = $userRepoEloquent;
        $this->service = $userService;

        $this->middleware('can:permission-admin-users')->only(['index']);
        $this->middleware('can:permission-admin-user-create')->only(['create', 'store']);
        $this->middleware('can:permission-admin-user-edit')->only(['edit', 'update']);
        $this->middleware('can:permission-admin-user-delete')->only(['destroy']);
        $this->middleware('can:permission-admin-user-status')->only(['status']);
        $this->middleware('can:permission-admin-user-activation')->only(['activation']);
        $this->middleware('can:permission-admin-user-roles')->only(['roleForm', 'roleUpdate']);
    }


    /**
     * @return Application|Factory|View
     */
    public function index(): View|Factory|Application
    {
        $adminUsers = $this->repo->adminUsers()->paginate(10);
        return view('User::admin-user.index', compact('adminUsers'));
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
     * @param ImageService $imageService
     * @return RedirectResponse
     */
    public function store(AdminUserRequest $request, ImageService $imageService): \Illuminate\Http\RedirectResponse
    {
        $inputs = $request->all();
        if ($request->hasFile('profile_photo_path')) {
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'users');
            $result = $imageService->save($request->file('profile_photo_path'));

            if ($result === false) {
                return redirect()->route('adminUser.index')->with('swal-error', 'آپلود تصویر با خطا مواجه شد');
            }
            $inputs['profile_photo_path'] = $result;
        }
        $inputs['password'] = Hash::make($request->password);
        $inputs['user_type'] = 1;
        $user = User::query()->create($inputs);
        return redirect()->route('adminUser.index')->with('swal-success', 'ادمین جدید با موفقیت ثبت شد');
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
        return view('User::admin-user.edit', compact('adminUser'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param AdminUserRequest $request
     * @param User $adminUser
     * @param ImageService $imageService
     * @return RedirectResponse
     */
    public function update(AdminUserRequest $request, User $adminUser, ImageService $imageService): RedirectResponse
    {
        $inputs = $request->all();

        if ($request->hasFile('profile_photo_path')) {
            if (!empty($adminUser->profile_photo_path)) {
                $imageService->deleteImage($adminUser->profile_photo_path);
            }
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'users');
            $result = $imageService->save($request->file('profile_photo_path'));
            if ($result === false) {
                return redirect()->route('adminUser.index')->with('swal-error', 'آپلود تصویر با خطا مواجه شد');
            }
            $inputs['profile_photo_path'] = $result;
        }
        $adminUser->update($inputs);
        return redirect()->route('adminUser.index')->with('swal-success', 'ادمین سایت شما با موفقیت ویرایش شد');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $adminUser
     * @return RedirectResponse
     */
    public function destroy(User $adminUser): RedirectResponse
    {
        $result = $adminUser->forceDelete();
        return redirect()->route('adminUser.index')->with('swal-success', 'ادمین شما با موفقیت حذف شد');
    }

    /**
     * @param User $user
     * @return JsonResponse
     */
    public function status(User $user): JsonResponse
    {

        $user->status = $user->status == 0 ? 1 : 0;
        $result = $user->save();
        if ($result) {
            if ($user->status == 0) {
                return response()->json(['status' => true, 'checked' => false]);
            } else {
                return response()->json(['status' => true, 'checked' => true]);
            }
        } else {
            return response()->json(['status' => false]);
        }
    }

    /**
     * @param User $user
     * @return JsonResponse
     */
    public function activation(User $user): JsonResponse
    {
        $user->activation = $user->activation == 0 ? 1 : 0;
        $result = $user->save();
        if ($result) {
            if ($user->activation == 0) {
                return response()->json(['status' => true, 'checked' => false]);
            } else {
                return response()->json(['status' => true, 'checked' => true]);
            }
        } else {
            return response()->json(['status' => false]);
        }
    }

    /**
     * @param User $admin
     * @return Application|Factory|View
     */
    public function roles(User $admin): View|Factory|Application
    {
        $roles = Role::all();
        return view('User::admin-user.roles', compact('admin', 'roles'));
    }

    /**
     * @param Request $request
     * @param User $admin
     * @return RedirectResponse
     */
    public function rolesStore(Request $request, User $admin): RedirectResponse
    {
        $validated = $request->validate([
            'roles' => 'required|exists:roles,id|array'
        ]);

        $admin->roles()->sync($request->roles);
        return redirect()->route('adminUser.index')->with('swal-success', 'نقش با موفقیت ویرایش شد');
    }


    /**
     * @param User $admin
     * @return Application|Factory|View
     */
    public function permissions(User $admin): View|Factory|Application
    {
        $permissions = Permission::all();
        return view('User::admin-user.permissions', compact(['admin', 'permissions']));
    }

    /**
     * @param Request $request
     * @param User $admin
     * @return RedirectResponse
     */
    public function permissionsStore(Request $request, User $admin): RedirectResponse
    {
        $validated = $request->validate([
            'permissions' => 'required|exists:permissions,id|array'
        ]);

        $admin->permissions()->sync($request->permissions);
        return redirect()->route('adminUser.index')->with('swal-success', 'سطح دسترسی با موفقیت ویرایش شد');

    }
}

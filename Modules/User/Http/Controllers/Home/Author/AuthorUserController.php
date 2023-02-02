<?php

namespace Modules\User\Http\Controllers\Home\Author;


use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Modules\ACL\Repositories\RolePermissionRepoEloquentInterface;
use Modules\Share\Http\Controllers\Controller;
use Modules\Share\Services\ShareService;
use Modules\Share\Traits\ShowMessageWithRedirectTrait;
use Modules\User\Entities\User;
use Modules\User\Http\Requests\AdminUserRequest;
use Modules\User\Http\Requests\UserPermissionsRequest;
use Modules\User\Http\Requests\UserRolesRequest;
use Modules\User\Repositories\UserRepoEloquentInterface;
use Modules\User\Services\UserService;

class AuthorUserController extends Controller
{
    use ShowMessageWithRedirectTrait;

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
    }


    /**
     * @param User $user
     * @return Application|Factory|View|RedirectResponse
     */
    public function index(User $user): View|Factory|Application|RedirectResponse
    {
        $this->setMetas($user);
        $relatedPosts = $user->posts()->latest()->take(10)->get();
        return view('User::home.author.index', compact(['user', 'relatedPosts']));
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
        $this->service->store($request, User::TYPE_ADMIN);
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
        $this->service->update($request, $adminUser);
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

    /**
     * @param $user
     * @return void
     */
    private function setMetas($user): void
    {
        SEOMeta::setKeywords($user->fullName);
        SEOTools::setTitle($user->fullName);
        SEOTools::setDescription($user->fullName);
        SEOTools::opengraph()->setUrl('http://current.url.com');
        SEOTools::setCanonical('https://codecasts.com.br/lesson');
        SEOTools::opengraph()->addProperty('type', 'articles');
        SEOTools::twitter()->setSite('@LuizVinicius73');
        SEOTools::jsonLd()->addImage('https://codecasts.com.br/img/logo.jpg');
    }
}

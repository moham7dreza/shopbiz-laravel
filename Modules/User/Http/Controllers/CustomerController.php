<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Modules\Share\Http\Controllers\Controller;
use Modules\Share\Http\Services\Image\ImageService;
use Modules\User\Entities\User;
use Modules\User\Http\Requests\CustomerRequest;
use Modules\User\Notifications\NewUserRegistered;
use Modules\User\Repositories\UserRepoEloquentInterface;
use Modules\User\Services\UserService;

class CustomerController extends Controller
{

    private string $redirectRoute = 'customer-user.index';

    private string $class = User::class;

    public UserRepoEloquentInterface $repo;
    public UserService $service;

    public function __construct(UserRepoEloquentInterface $userRepoEloquent, UserService $userService)
    {
        $this->repo = $userRepoEloquent;
        $this->service = $userService;

        $this->middleware('can:permission-customer-users')->only(['index']);
        $this->middleware('can:permission-customer-user-create')->only(['create', 'store']);
        $this->middleware('can:permission-customer-user-edit')->only(['edit', 'update']);
        $this->middleware('can:permission-customer-user-delete')->only(['destroy']);
        $this->middleware('can:permission-customer-user-status')->only(['status']);
        $this->middleware('can:permission-customer-user-activation')->only(['activation']);
    }
    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $users = User::query()->where('user_type', 0)->get();
        return view('User::customer.index', compact('users'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('User::customer.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CustomerRequest $request
     * @param ImageService $imageService
     * @return RedirectResponse
     */
    public function store(CustomerRequest $request, ImageService $imageService): \Illuminate\Http\RedirectResponse
    {
        $inputs = $request->all();
        if ($request->hasFile('profile_photo_path')) {
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'users');
            $result = $imageService->save($request->file('profile_photo_path'));

            if ($result === false) {
                return redirect()->route('customer-user.index')->with('swal-error', 'آپلود تصویر با خطا مواجه شد');
            }
            $inputs['profile_photo_path'] = $result;
        }
        $inputs['password'] = Hash::make($request->password);
        $inputs['user_type'] = 0;
        $user = User::query()->create($inputs);
        $details = [
            'message' => 'یک کاربر جدید در سایت ثبت نام کرد'
        ];
        $adminUser = User::query()->find(1);
        $adminUser->notify(new NewUserRegistered($details));
        return redirect()->route('customer-user.index')->with('swal-success', 'مشتری جدید با موفقیت ثبت شد');
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
     * @param User $user
     * @return Application|Factory|View
     */
    public function edit(User $user)
    {
        return view('User::customer.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CustomerRequest $request
     * @param User $user
     * @param ImageService $imageService
     * @return RedirectResponse
     */
    public function update(CustomerRequest $request, User $user, ImageService $imageService): RedirectResponse
    {
        $inputs = $request->all();

        if ($request->hasFile('profile_photo_path')) {
            if (!empty($user->profile_photo_path)) {
                $imageService->deleteImage($user->profile_photo_path);
            }
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'users');
            $result = $imageService->save($request->file('profile_photo_path'));
            if ($result === false) {
                return redirect()->route('customer-user.index')->with('swal-error', 'آپلود تصویر با خطا مواجه شد');
            }
            $inputs['profile_photo_path'] = $result;
        }
        $user->update($inputs);
        return redirect()->route('customer-user.index')->with('swal-success', 'مشتری سایت شما با موفقیت ویرایش شد');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return RedirectResponse
     */
    public function destroy(User $user): RedirectResponse
    {
        $result = $user->forceDelete();
        return redirect()->route('customer-user.index')->with('swal-success', 'مشتری شما با موفقیت حذف شد');
    }


    /**
     * @param User $user
     * @return JsonResponse
     */
    public function status(User $user)
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
}

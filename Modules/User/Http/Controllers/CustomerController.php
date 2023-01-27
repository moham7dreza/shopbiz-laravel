<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Modules\Share\Http\Controllers\Controller;
use Modules\Share\Services\ShareService;
use Modules\Share\Traits\ShowMessageWithRedirectTrait;
use Modules\User\Entities\User;
use Modules\User\Http\Requests\CustomerRequest;
use Modules\User\Repositories\UserRepoEloquentInterface;
use Modules\User\Services\UserService;

class CustomerController extends Controller
{
    use ShowMessageWithRedirectTrait;
    /**
     * @var string
     */
    private string $redirectRoute = 'customerUser.index';

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

        $this->middleware('can:permission-customer-users')->only(['index']);
        $this->middleware('can:permission-customer-user-create')->only(['create', 'store']);
        $this->middleware('can:permission-customer-user-edit')->only(['edit', 'update']);
        $this->middleware('can:permission-customer-user-delete')->only(['destroy']);
        $this->middleware('can:permission-customer-user-status')->only(['status']);
        $this->middleware('can:permission-customer-user-activation')->only(['activation']);
    }

    /**
     * @return Application|Factory|View|RedirectResponse
     */
    public function index(): View|Factory|Application|RedirectResponse
    {
        if (isset(request()->search)) {
            $users = $this->repo->search(request()->search)->paginate(10);
            if (count($users) > 0) {
                $this->showToastOfFetchedRecordsCount(count($users));
            } else {
                return $this->showAlertOfNotResultFound();
            }
        } else {
            $users = $this->repo->customerUsers()->paginate(10);
        }

        return view('User::customer.index', compact(['users']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(): View|Factory|Application
    {
        return view('User::customer.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CustomerRequest $request
     * @return RedirectResponse
     */
    public function store(CustomerRequest $request): \Illuminate\Http\RedirectResponse
    {
        $this->service->store($request);
        $adminUser = $this->repo->findById(1);
        $this->service->sendUserCreatedNotificationToAdmin($adminUser);
        return $this->showMessageWithRedirectRoute('مشتری جدید با موفقیت ثبت شد');
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
     * @param User $customerUser
     * @return Application|Factory|View
     */
    public function edit(User $customerUser): View|Factory|Application
    {
        return view('User::customer.edit', compact(['customerUser']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CustomerRequest $request
     * @param User $customerUser
     * @return RedirectResponse
     */
    public function update(CustomerRequest $request, User $customerUser): RedirectResponse
    {
        $this->service->update($request, $customerUser);
        return $this->showMessageWithRedirectRoute('مشتری سایت شما با موفقیت ویرایش شد');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $customerUser
     * @return RedirectResponse
     */
    public function destroy(User $customerUser): RedirectResponse
    {
        $result = $customerUser->delete();
        return $this->showMessageWithRedirectRoute('مشتری شما با موفقیت حذف شد');
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
}

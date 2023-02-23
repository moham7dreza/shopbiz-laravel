<?php

namespace Modules\Discount\Http\Controllers;


use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Modules\ACL\Entities\Permission;
use Modules\Discount\Entities\Copan;
use Modules\Discount\Http\Requests\CopanRequest;
use Modules\Discount\Repositories\Copan\CopanDiscountRepoEloquentInterface;
use Modules\Discount\Services\Copan\CopanDiscountService;
use Modules\Share\Http\Controllers\Controller;
use Modules\Share\Services\ShareService;
use Modules\Share\Traits\ShowMessageWithRedirectTrait;
use Modules\User\Repositories\UserRepoEloquentInterface;

class CopanController extends Controller
{
    use ShowMessageWithRedirectTrait;

    /**
     * @var string
     */
    public string $redirectRoute = 'copanDiscount.index';

    /**
     * @var string
     */
    private string $class = Copan::class;
    public CopanDiscountRepoEloquentInterface $repo;
    public CopanDiscountService $service;

    /**
     * @param CopanDiscountRepoEloquentInterface $repo
     * @param CopanDiscountService $service
     */
    public function __construct(CopanDiscountRepoEloquentInterface $repo, CopanDiscountService $service,)
    {
        $this->repo = $repo;
        $this->service = $service;

        // set middlewares
        $this->middleware('can:'. Permission::PERMISSION_COUPON_DISCOUNTS)->only(['index']);
        $this->middleware('can:'. Permission::PERMISSION_COUPON_DISCOUNT_CREATE)->only(['create', 'store']);
        $this->middleware('can:'. Permission::PERMISSION_COUPON_DISCOUNT_EDIT)->only(['edit', 'update']);
        $this->middleware('can:'. Permission::PERMISSION_COUPON_DISCOUNT_DELETE)->only(['destroy']);
        $this->middleware('can:'. Permission::PERMISSION_COUPON_DISCOUNT_STATUS)->only(['status']);
    }

    /**
     * @return Application|Factory|View|RedirectResponse
     */
    public function index(): Factory|View|Application|RedirectResponse
    {
        if (isset(request()->search)) {
            $copans = $this->repo->search(request()->search)->paginate(10);
            if (count($copans) > 0) {
                $this->showToastOfFetchedRecordsCount(count($copans));
            } else {
                return $this->showAlertOfNotResultFound();
            }
        } elseif (isset(request()->sort)) {
            $copans = $this->repo->sort(request()->sort, request()->dir)->paginate(10);
            $this->showToastOfSelectedDirection(request()->dir);
        } else {
            $copans = $this->repo->getLatestOrderByDate()->paginate(10);
        }

        return view('Discount::copan.index', compact(['copans']));
    }

    /**
     * @param UserRepoEloquentInterface $userRepo
     * @return Application|Factory|View
     */
    public function create(UserRepoEloquentInterface $userRepo): View|Factory|Application
    {
        $users = $userRepo->index()->get()->except([1]);
        if ($users->count() < 1) {
            ShareService::showAnimatedToast(title: 'برای تخصیص کپن تخفیف خصوصی باید ابتدا کاربر ایجاد کنید.', type: 'info');
        }
        return view('Discount::copan.create', compact(['users']));
    }

    /**
     * @param CopanRequest $request
     * @return RedirectResponse
     */
    public function store(CopanRequest $request): RedirectResponse
    {
        $this->service->store($request);
        return $this->showMessageWithRedirectRoute(' کد تخفیف جدید شما با موفقیت ثبت شد');
    }


    /**
     * @param Copan $copanDiscount
     * @param UserRepoEloquentInterface $userRepo
     * @return Application|Factory|View
     */
    public function edit(Copan $copanDiscount, UserRepoEloquentInterface $userRepo): View|Factory|Application
    {
        $users = $userRepo->index()->get();
        return view('Discount::copan.edit', compact(['copanDiscount', 'users']));
    }

    /**
     * @param CopanRequest $request
     * @param Copan $copanDiscount
     * @return RedirectResponse
     */
    public function update(CopanRequest $request, Copan $copanDiscount): RedirectResponse
    {
        $this->service->update($request, $copanDiscount);
        return $this->showMessageWithRedirectRoute('کد تخفیف  شما با موفقیت ویرایش شد');
    }


    /**
     * @param Copan $copanDiscount
     * @return RedirectResponse
     */
    public function destroy(Copan $copanDiscount): RedirectResponse
    {
        $result = $copanDiscount->delete();
        return $this->showMessageWithRedirectRoute(' تخفیف  شما با موفقیت حذف شد');
    }

    /**
     * @param Copan $copanDiscount
     * @return JsonResponse
     */
    public function status(Copan $copanDiscount): JsonResponse
    {
        return ShareService::changeStatus($copanDiscount);
    }
}

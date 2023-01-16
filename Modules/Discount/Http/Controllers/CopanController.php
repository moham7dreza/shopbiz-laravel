<?php

namespace Modules\Discount\Http\Controllers;


use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Modules\Discount\Entities\Copan;
use Modules\Discount\Http\Requests\CopanRequest;
use Modules\Discount\Repositories\Copan\CopanDiscountRepoEloquentInterface;
use Modules\Discount\Services\Copan\CopanDiscountService;
use Modules\Share\Http\Controllers\Controller;
use Modules\Share\Services\ShareService;
use Modules\Share\Traits\SuccessToastMessageWithRedirectTrait;
use Modules\User\Repositories\UserRepoEloquentInterface;

class CopanController extends Controller
{
    use SuccessToastMessageWithRedirectTrait;

    /**
     * @var string
     */
    public string $redirectRoute = 'copanDiscount.index';

    /**
     * @var string
     */
    private string $class = Copan::class;
    public CopanDiscountRepoEloquentInterface $copanDiscountRepo;
    public CopanDiscountService $copanDiscountService;

    /**
     * @param CopanDiscountRepoEloquentInterface $copanDiscountRepo
     * @param CopanDiscountService $copanDiscountService
     */
    public function __construct(CopanDiscountRepoEloquentInterface $copanDiscountRepo, CopanDiscountService $copanDiscountService,)
    {
        $this->copanDiscountRepo = $copanDiscountRepo;
        $this->copanDiscountService = $copanDiscountService;

        // set middlewares
        $this->middleware('can:permission-product-coupon-discounts')->only(['copan']);
        $this->middleware('can:permission-product-coupon-discount-create')->only(['copanCreate', 'copanStore']);
        $this->middleware('can:permission-product-coupon-discount-edit')->only(['copanEdit', 'copanUpdate']);
        $this->middleware('can:permission-product-coupon-discount-delete')->only(['copanDestroy']);
    }

    /**
     * @return Application|Factory|View
     */
    public function index(): Factory|View|Application
    {
        $copans = $this->copanDiscountRepo->getLatest()->paginate(10);
        return view('Discount::copan.index', compact(['copans']));
    }

    /**
     * @param UserRepoEloquentInterface $userRepo
     * @return Application|Factory|View
     */
    public function create(UserRepoEloquentInterface $userRepo): View|Factory|Application
    {
        $users = $userRepo->index()->get();
        return view('Discount::copan.create', compact(['users']));
    }

    /**
     * @param CopanRequest $request
     * @return RedirectResponse
     */
    public function store(CopanRequest $request): RedirectResponse
    {
        $this->copanDiscountService->store($request);
        return $this->successMessageWithRedirect(' کد تخفیف جدید شما با موفقیت ثبت شد');
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
        $this->copanDiscountService->update($request, $copanDiscount);
        return $this->successMessageWithRedirect('کد تخفیف  شما با موفقیت ویرایش شد');
    }


    /**
     * @param Copan $copanDiscount
     * @return RedirectResponse
     */
    public function destroy(Copan $copanDiscount): RedirectResponse
    {
        $result = $copanDiscount->delete();
        return $this->successMessageWithRedirect(' تخفیف  شما با موفقیت حذف شد');
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

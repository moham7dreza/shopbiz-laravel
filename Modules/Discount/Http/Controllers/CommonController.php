<?php

namespace Modules\Discount\Http\Controllers;


use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Modules\Discount\Entities\CommonDiscount;
use Modules\Discount\Http\Requests\CommonDiscountRequest;
use Modules\Discount\Repositories\Common\CommonDiscountRepoEloquentInterface;
use Modules\Discount\Services\Common\CommonDiscountService;
use Modules\Share\Http\Controllers\Controller;
use Modules\Share\Services\ShareService;
use Modules\Share\Traits\SuccessToastMessageWithRedirectTrait;

class CommonController extends Controller
{
    use SuccessToastMessageWithRedirectTrait;

    /**
     * @var string
     */
    public string $redirectRoute = 'commonDiscount.index';

    /**
     * @var string
     */
    private string $class = CommonDiscount::class;

    public CommonDiscountRepoEloquentInterface $commonDiscountRepo;
    public CommonDiscountService $commonDiscountService;

    /**
     * @param CommonDiscountRepoEloquentInterface $commonDiscountRepo
     * @param CommonDiscountService $commonDiscountService
     */
    public function __construct(CommonDiscountRepoEloquentInterface $commonDiscountRepo, CommonDiscountService $commonDiscountService)
    {
        $this->commonDiscountRepo = $commonDiscountRepo;
        $this->commonDiscountService = $commonDiscountService;

        // set middlewares
        $this->middleware('can:permission-product-common-discounts')->only(['commonDiscount']);
        $this->middleware('can:permission-product-common-discount-create')->only(['commonDiscountCreate', 'commonDiscountStore']);
        $this->middleware('can:permission-product-common-discount-edit')->only(['commonDiscountEdit', 'commonDiscountUpdate']);
        $this->middleware('can:permission-product-common-discount-delete')->only(['commonDiscountDestroy']);
    }


    /**
     * @return Application|Factory|View
     */
    public function index(): View|Factory|Application
    {
        $commonDiscounts = $this->commonDiscountRepo->getLatest()->paginate(10);
        return view('Discount::common.index', compact(['commonDiscounts']));
    }

    /**
     * @return Application|Factory|View
     */
    public function create(): View|Factory|Application
    {
        return view('Discount::common.create');
    }

    /**
     * @param CommonDiscountRequest $request
     * @return RedirectResponse
     */
    public function store(CommonDiscountRequest $request): RedirectResponse
    {
        $this->commonDiscountService->store($request);
        return $this->successMessageWithRedirect('کد تخفیف جدید شما با موفقیت ثبت شد');
    }


    /**
     * @param CommonDiscount $commonDiscount
     * @return Application|Factory|View
     */
    public function edit(CommonDiscount $commonDiscount): View|Factory|Application
    {
        return view('Discount::common.edit', compact(['commonDiscount']));
    }

    /**
     * @param CommonDiscountRequest $request
     * @param CommonDiscount $commonDiscount
     * @return RedirectResponse
     */
    public function update(CommonDiscountRequest $request, CommonDiscount $commonDiscount): RedirectResponse
    {
        $this->commonDiscountService->update($request, $commonDiscount);
        return $this->successMessageWithRedirect('کد تخفیف جدید شما با موفقیت ویرایش شد');
    }

    /**
     * @param CommonDiscount $commonDiscount
     * @return RedirectResponse
     */
    public function destroy(CommonDiscount $commonDiscount): RedirectResponse
    {
        $result = $commonDiscount->delete();
        return $this->successMessageWithRedirect('کد تخفیف  شما با موفقیت حذف شد');
    }

    /**
     * @param CommonDiscount $commonDiscount
     * @return JsonResponse
     */
    public function status(CommonDiscount $commonDiscount): JsonResponse
    {
        return ShareService::changeStatus($commonDiscount);
    }
}

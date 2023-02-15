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
use Modules\Share\Traits\ShowMessageWithRedirectTrait;

class CommonController extends Controller
{
    use ShowMessageWithRedirectTrait;

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
        $this->middleware('can:permission common discounts')->only(['index']);
        $this->middleware('can:permission common discount create')->only(['create', 'store']);
        $this->middleware('can:permission common discount edit')->only(['edit', 'update']);
        $this->middleware('can:permission common discount delete')->only(['destroy']);
        $this->middleware('can:permission common discount status')->only(['status']);
    }


    /**
     * @return Application|Factory|View|RedirectResponse
     */
    public function index(): View|Factory|Application|RedirectResponse
    {
        if (isset(request()->search)) {
            $commonDiscounts = $this->commonDiscountRepo->search(request()->search)->paginate(10);
            if (count($commonDiscounts) > 0) {
                $this->showToastOfFetchedRecordsCount(count($commonDiscounts));
            } else {
                return $this->showAlertOfNotResultFound();
            }
        } else {
            $commonDiscounts = $this->commonDiscountRepo->getLatestOrderByDate()->paginate(10);
        }

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
        return $this->showMessageWithRedirectRoute('کد تخفیف جدید شما با موفقیت ثبت شد');
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
        return $this->showMessageWithRedirectRoute('کد تخفیف جدید شما با موفقیت ویرایش شد');
    }

    /**
     * @param CommonDiscount $commonDiscount
     * @return RedirectResponse
     */
    public function destroy(CommonDiscount $commonDiscount): RedirectResponse
    {
        $result = $commonDiscount->delete();
        return $this->showMessageWithRedirectRoute('کد تخفیف  شما با موفقیت حذف شد');
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

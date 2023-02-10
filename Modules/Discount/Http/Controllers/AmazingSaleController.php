<?php

namespace Modules\Discount\Http\Controllers;


use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Modules\Discount\Entities\AmazingSale;
use Modules\Discount\Http\Requests\AmazingSaleRequest;
use Modules\Discount\Repositories\AmazingSale\AmazingSaleDiscountRepoEloquentInterface;
use Modules\Discount\Services\AmazingSale\AmazingSaleDiscountService;
use Modules\Product\Repositories\Product\ProductRepoEloquentInterface;
use Modules\Share\Http\Controllers\Controller;
use Modules\Share\Services\ShareService;
use Modules\Share\Traits\ShowMessageWithRedirectTrait;

class AmazingSaleController extends Controller
{
    use ShowMessageWithRedirectTrait;

    /**
     * @var string
     */
    public string $redirectRoute = 'amazingSale.index';

    /**
     * @var string
     */
    private string $class = AmazingSale::class;

    public AmazingSaleDiscountRepoEloquentInterface $amazingSaleDiscountRepo;
    public AmazingSaleDiscountService $amazingSaleDiscountService;
    public ProductRepoEloquentInterface $productRepo;

    /**
     * @param AmazingSaleDiscountRepoEloquentInterface $amazingSaleDiscountRepo
     * @param AmazingSaleDiscountService $amazingSaleDiscountService
     */
    public function __construct(AmazingSaleDiscountRepoEloquentInterface $amazingSaleDiscountRepo, AmazingSaleDiscountService $amazingSaleDiscountService,
                                ProductRepoEloquentInterface $productRepo)
    {
        $this->amazingSaleDiscountRepo = $amazingSaleDiscountRepo;
        $this->amazingSaleDiscountService = $amazingSaleDiscountService;
        $this->productRepo = $productRepo;

        // set middlewares
        $this->middleware('can:permission-product-amazing-sales')->only(['amazingSale']);
        $this->middleware('can:permission-product-amazing-sale-create')->only(['amazingSaleCreate', 'amazingSaleStore']);
        $this->middleware('can:permission-product-amazing-sale-edit')->only(['amazingSaleEdit', 'amazingSaleUpdate']);
        $this->middleware('can:permission-product-amazing-sale-delete')->only(['amazingSaleDestroy']);
    }

    /**
     * @return Application|Factory|View|RedirectResponse
     */
    public function index(): View|Factory|Application|RedirectResponse
    {
        if (isset(request()->search)) {
            $amazingSales = $this->amazingSaleDiscountRepo->search(request()->search)->paginate(10);
            if (count($amazingSales) > 0) {
                $this->showToastOfFetchedRecordsCount(count($amazingSales));
            } else {
                return $this->showAlertOfNotResultFound();
            }
        } else {
            $amazingSales = $this->amazingSaleDiscountRepo->getLatestOrderByDate()->paginate(10);
        }

        return view('Discount::amazingSale.index', compact(['amazingSales']));
    }

    /**
     * @param ProductRepoEloquentInterface $productRepo
     * @return Application|Factory|View|RedirectResponse
     */
    public function create(ProductRepoEloquentInterface $productRepo): View|Factory|Application|RedirectResponse
    {
        $products = $productRepo->index()->get();
        if ($products->count() > 0) {
            return view('Discount::amazingSale.create', compact(['products']));
        }
        return $this->showMessageWithRedirectRoute(msg: 'برای ایجاد تخفیف ابتدا باید محصول تعریف کنید.', title: 'خطا', status: 'error');
    }

    /**
     * @param AmazingSaleRequest $request
     * @return RedirectResponse
     */
    public function store(AmazingSaleRequest $request): RedirectResponse
    {
        $amazingSale = $this->amazingSaleDiscountService->store($request);
        $this->updateActiveDiscountInProduct($amazingSale);
        return $this->showMessageWithRedirectRoute(' تخفیف جدید شما با موفقیت ثبت شد');
    }

    /**
     * @param AmazingSale $amazingSale
     * @param ProductRepoEloquentInterface $productRepo
     * @return View|Factory|Application
     */
    public function edit(AmazingSale $amazingSale, ProductRepoEloquentInterface $productRepo): View|Factory|Application
    {
        $products = $productRepo->index()->get();
        return view('Discount::amazingSale.edit', compact(['amazingSale', 'products']));
    }

    /**
     * @param AmazingSaleRequest $request
     * @param AmazingSale $amazingSale
     * @return RedirectResponse
     */
    public function update(AmazingSaleRequest $request, AmazingSale $amazingSale): RedirectResponse
    {
        $result = $this->amazingSaleDiscountService->update($request, $amazingSale);
        $this->updateActiveDiscountInProduct($amazingSale);
        return $this->showMessageWithRedirectRoute(' تخفیف  شما با موفقیت ویرایش شد');
    }


    /**
     * @param AmazingSale $amazingSale
     * @return RedirectResponse
     */
    public function destroy(AmazingSale $amazingSale): RedirectResponse
    {
        $result = $amazingSale->delete();
        return $this->showMessageWithRedirectRoute(' تخفیف  شما با موفقیت حذف شد');
    }

    /**
     * @param AmazingSale $amazingSale
     * @return JsonResponse
     */
    public function status(AmazingSale $amazingSale): JsonResponse
    {
        return ShareService::changeStatus($amazingSale);
    }

    /**
     * @param $amazingSale
     * @return void
     */
    private function updateActiveDiscountInProduct($amazingSale): void
    {
        $product = $this->productRepo->findById($amazingSale->product_id);
        if ($amazingSale->activated()) {
            $product->active_discount_percentage = $amazingSale->percentage;
        } else {
            $product->active_discount_percentage = null;
        }
        $product->save();
    }
}

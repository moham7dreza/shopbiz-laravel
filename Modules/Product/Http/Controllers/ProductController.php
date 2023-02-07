<?php

namespace Modules\Product\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Modules\Brand\Repositories\BrandRepoEloquentInterface;
use Modules\Category\Repositories\ProductCategory\ProductCategoryRepoEloquentInterface;
use Modules\Product\Entities\Product;
use Modules\Product\Http\Requests\ProductRequest;
use Modules\Product\Repositories\Product\ProductRepoEloquentInterface;
use Modules\Product\Services\Product\ProductService;
use Modules\Setting\Repositories\SettingRepoEloquent;
use Modules\Share\Http\Controllers\Controller;
use Modules\Share\Services\ShareService;
use Modules\Share\Traits\ShowMessageWithRedirectTrait;
use Modules\Tag\Repositories\TagRepositoryEloquentInterface;

class ProductController extends Controller
{
    use ShowMessageWithRedirectTrait;

    /**
     * @var string
     */
    private string $redirectRoute = 'product.index';

    /**
     * @var string
     */
    private string $class = Product::class;

    public ProductRepoEloquentInterface $repo;
    public ProductService $service;

    /**
     * @param ProductRepoEloquentInterface $productRepoEloquent
     * @param ProductService $productService
     */
    public function __construct(ProductRepoEloquentInterface $productRepoEloquent, ProductService $productService)
    {
        $this->repo = $productRepoEloquent;
        $this->service = $productService;

        $this->middleware('can:permission-products')->only(['index']);
        $this->middleware('can:permission-product-create')->only(['create', 'store']);
        $this->middleware('can:permission-product-edit')->only(['edit', 'update']);
        $this->middleware('can:permission-product-delete')->only(['destroy']);
        $this->middleware('can:permission-product-status')->only(['status']);
    }

    /**
     * @return Application|Factory|View|RedirectResponse
     */
    public function index(): View|Factory|Application|RedirectResponse
    {
        if (isset(request()->search)) {
            $products = $this->repo->search(request()->search)->paginate(10);
            if (count($products) > 0) {
                $this->showToastOfFetchedRecordsCount(count($products));
            } else {
                return $this->showAlertOfNotResultFound();
            }
        } else {
            $products = $this->repo->index()->with('tags')->paginate(10);
        }
        if ($products->count() > 0) {
            $this->calcTotalRate();
        }
        return view('Product::admin.index', compact(['products']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param ProductCategoryRepoEloquentInterface $productCategoryRepo
     * @param BrandRepoEloquentInterface $brandRepo
     * @return Application|Factory|View|RedirectResponse
     */
    public function create(ProductCategoryRepoEloquentInterface $productCategoryRepo,
                           BrandRepoEloquentInterface           $brandRepo): View|Factory|Application|RedirectResponse
    {
        $productCategories = $productCategoryRepo->getNotParentCategories()->get();
        $brands = $brandRepo->index()->get();
        $findZero = null;
        if ($productCategories->count() > 0 && $brands->count() > 0) {
            return view('Product::admin.create', compact(['productCategories', 'brands']));
        }
        $findZero = $productCategories->count() > 0 ? 'برند' : 'دسته بندی';
        return $this->showMessageWithRedirectRoute(msg: 'برای ایجاد محصول ابتدا باید ' . $findZero . ' تعریف کنید.', title: 'خطا', status: 'error');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProductRequest $request
     * @return RedirectResponse
     */
    public function store(ProductRequest $request): RedirectResponse
    {
        $this->service->store($request);
        return $this->showMessageWithRedirectRoute('محصول جدید شما با موفقیت ثبت شد');
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
     * @param Product $product
     * @param ProductCategoryRepoEloquentInterface $productCategoryRepo
     * @param BrandRepoEloquentInterface $brandRepo
     * @return Application|Factory|View
     */
    public function edit(Product                              $product,
                         ProductCategoryRepoEloquentInterface $productCategoryRepo,
                         BrandRepoEloquentInterface           $brandRepo): View|Factory|Application
    {
        $productCategories = $productCategoryRepo->getLatestCategories()->get();
        $brands = $brandRepo->index()->get();
        return view('Product::admin.edit', compact(['product', 'productCategories', 'brands']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProductRequest $request
     * @param Product $product
     * @return RedirectResponse
     */
    public function update(ProductRequest $request, Product $product): RedirectResponse
    {
        $this->service->update($request, $product);
        return $this->showMessageWithRedirectRoute('محصول شما با موفقیت ویرایش شد');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Product $product
     * @return RedirectResponse
     */
    public function destroy(Product $product): RedirectResponse
    {
        $result = $product->delete();
        return $this->showMessageWithRedirectRoute('محصول ما با موفقیت حذف شد');
    }

    /**
     * @param Product $product
     * @return JsonResponse
     */
    public function status(Product $product): JsonResponse
    {
        return ShareService::ajaxChangeModelSpecialField($product);
    }

    /**
     * @param Product $product
     * @return JsonResponse
     */
    public function marketable(Product $product): JsonResponse
    {
        return ShareService::ajaxChangeModelSpecialField($product, 'marketable');
    }

    /**
     * @param Product $product
     * @return RedirectResponse
     */
    public function selected(Product $product): RedirectResponse
    {
        if ($product->selected == Product::NOT_SELECTED) {
            $product->selected = Product::SELECTED;
            $text = 'کالا به عنوان محصول پیشنهادی انتخاب شد.';
        } else {
            $product->selected = Product::NOT_SELECTED;
            $text = 'کالا از عنوان محصول پیشنهادی خارج شد.';
        }
        $product->save();
        return $this->showMessageWithRedirectRoute($text);
    }

    /**
     * @param Product $product
     * @param TagRepositoryEloquentInterface $tagRepositoryEloquent
     * @return Application|Factory|View
     */
    public function tagsForm(Product $product, TagRepositoryEloquentInterface $tagRepositoryEloquent): View|Factory|Application
    {
        $tags = $tagRepositoryEloquent->index()->get();
        return view('Product::admin.tags-form', compact(['product', 'tags']));
    }

    /**
     * @param ProductRequest $request
     * @param Product $product
     * @return RedirectResponse
     */
    public function setTags(ProductRequest $request, Product $product): RedirectResponse
    {
        $product->tags()->sync($request->tags);
        return $this->showMessageWithRedirectRoute('تگ های محصول با موفقیت بروزرسانی شد');
    }

    /**
     * @return void
     */
    private function calcTotalRate(): void
    {
        $settingRepo = new SettingRepoEloquent();
        $setting = $settingRepo->getSystemSetting();
        $setting->rating_score = $this->repo->index()->get()->sum('rating') / $this->repo->index()->count();
        $setting->save();
    }
}

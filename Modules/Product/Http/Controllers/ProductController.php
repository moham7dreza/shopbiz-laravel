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
use Modules\Share\Http\Controllers\Controller;
use Modules\Share\Services\ShareService;
use Modules\Share\Traits\SuccessToastMessageWithRedirectTrait;

class ProductController extends Controller
{
    use SuccessToastMessageWithRedirectTrait;

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
     * @return Application|Factory|View
     */
    public function index(): View|Factory|Application
    {
        $products = $this->repo->index()->paginate(10);
        return view('Product::admin.index', compact(['products']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param ProductCategoryRepoEloquentInterface $productCategoryRepo
     * @param BrandRepoEloquentInterface $brandRepo
     * @return Application|Factory|View
     */
    public function create(ProductCategoryRepoEloquentInterface $productCategoryRepo,
                           BrandRepoEloquentInterface           $brandRepo): View|Factory|Application
    {
        $productCategories = $productCategoryRepo->getLatestCategories()->get();
        $brands = $brandRepo->index()->get();
        return view('Product::admin.create', compact(['productCategories', 'brands']));
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
        return $this->successMessageWithRedirect('محصول جدید شما با موفقیت ثبت شد');
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
        return $this->successMessageWithRedirect('محصول شما با موفقیت ویرایش شد');
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
        return $this->successMessageWithRedirect('محصول ما با موفقیت حذف شد');
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
}

<?php

namespace Modules\Product\Http\Controllers;


use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Modules\Product\Entities\Product;
use Modules\Product\Http\Requests\StoreRequest;
use Modules\Product\Http\Requests\StoreUpdateRequest;
use Modules\Product\Repositories\Product\ProductRepoEloquentInterface;
use Modules\Product\Services\Product\ProductServiceInterface;
use Modules\Product\Services\Store\ProductStoreServiceInterface;
use Modules\Share\Http\Controllers\Controller;
use Modules\Share\Traits\SuccessToastMessageWithRedirectTrait;

class StoreController extends Controller
{
    use SuccessToastMessageWithRedirectTrait;

    /**
     * @var string
     */
    private string $redirectRoute = 'product.store.index';

    public ProductServiceInterface $productService;

    /**
     * @var string
     */
    private string $class = Product::class;
    public function __construct(ProductServiceInterface $productService)
    {
        $this->productService = $productService;

        $this->middleware('can:permission-product-warehouse')->only(['index']);
        $this->middleware('can:permission-product-warehouse-add')->only(['addToStore', 'store']);
        $this->middleware('can:permission-product-warehouse-modify')->only(['edit', 'update']);
    }

    /**
     * @param ProductRepoEloquentInterface $productRepo
     * @return Application|Factory|View
     */
    public function index(ProductRepoEloquentInterface $productRepo): Factory|View|Application
    {
        $products = $productRepo->index()->paginate(10);
        return view('Product::admin.store.index', compact(['products']));
    }


    /**
     * @param Product $product
     * @return Application|Factory|View
     */
    public function addToStore(Product $product): View|Factory|Application
    {
        return view('Product::admin.store.add-to-store', compact(['product']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRequest $request
     * @param Product $product
     * @return RedirectResponse
     */
    public function store(StoreRequest $request, Product $product): \Illuminate\Http\RedirectResponse
    {
        $this->productService->productAddToStore($request, $product);
        return $this->successMessageWithRedirect('موجودی جدید با موفقیت ثبت شد');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
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
     * @return Application|Factory|View
     */
    public function edit(Product $product): View|Factory|Application
    {
        return view('Product::admin.store.edit', compact(['product']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreUpdateRequest $request
     * @param Product $product
     * @return RedirectResponse
     */
    public function update(StoreUpdateRequest $request, Product $product): RedirectResponse
    {
        $this->productService->updateProductStore($request, $product);
        return $this->successMessageWithRedirect('موجودی با موفقیت ویرایش شد');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort(403);
    }
}

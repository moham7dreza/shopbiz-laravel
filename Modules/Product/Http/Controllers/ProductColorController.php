<?php

namespace Modules\Product\Http\Controllers;


use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\ProductColor;
use Modules\Product\Http\Requests\ProductColorRequest;
use Modules\Product\Repositories\Color\ProductColorRepoEloquentInterface;
use Modules\Product\Services\Color\ProductColorService;
use Modules\Share\Http\Controllers\Controller;
use Modules\Share\Services\ShareService;
use Modules\Share\Traits\ShowMessageWithRedirectTrait;

class ProductColorController extends Controller
{
    use ShowMessageWithRedirectTrait;

    /**
     * @var string
     */
    private string $redirectRoute = 'product.color.index';

    /**
     * @var string
     */
    private string $class = ProductColor::class;

    public ProductColorRepoEloquentInterface $repo;
    public ProductColorService $service;

    /**
     * @param ProductColorRepoEloquentInterface $colorRepoEloquent
     * @param ProductColorService $colorService
     */
    public function __construct(ProductColorRepoEloquentInterface $colorRepoEloquent, ProductColorService $colorService)
    {
        $this->repo = $colorRepoEloquent;
        $this->service = $colorService;

        $this->middleware('can:permission-product-colors')->only(['index']);
        $this->middleware('can:permission-product-color-create')->only(['create', 'store']);
        $this->middleware('can:permission-product-color-delete')->only(['destroy']);
    }

    /**
     * @param Product $product
     * @return Application|Factory|View|RedirectResponse
     */
    public function index(Product $product): Factory|View|Application|RedirectResponse
    {
        if (isset(request()->search)) {
            $colors = $this->repo->search(request()->search, $product->id)->paginate(10);
            if (count($colors) > 0) {
                $this->showToastOfFetchedRecordsCount(count($colors));
            } else {
                return $this->showAlertOfNotResultFound();
            }
        } else {
            $colors = $product->colors()->paginate(10);
        }

        return view('Product::admin.color.index', compact(['product', 'colors']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Product $product
     * @return Application|Factory|View
     */
    public function create(Product $product): View|Factory|Application
    {
        return view('Product::admin.color.create', compact(['product']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProductColorRequest $request
     * @param Product $product
     * @return RedirectResponse
     */
    public function store(ProductColorRequest $request, Product $product): RedirectResponse
    {
        $this->service->store($request, $product->id);
        return $this->showMessageWithRedirect('رنگ شما با موفقیت ثبت شد', params: [$product]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        abort(403);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Product $product
     * @param ProductColor $color
     * @return Application|Factory|View
     */
    public function edit(Product $product, ProductColor $color): Application|Factory|View
    {
        return view('Product::admin.color.edit', compact(['product', 'color']));
    }


    /**
     * @param ProductColorRequest $request
     * @param Product $product
     * @param ProductColor $color
     * @return RedirectResponse
     */
    public function update(ProductColorRequest $request, Product $product, ProductColor $color): RedirectResponse
    {
        $this->service->update($request, $product->id, $color);
        return $this->showMessageWithRedirect('رنگ شما با موفقیت ویرایش شد', params: [$product]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Product $product
     * @param ProductColor $color
     * @return RedirectResponse
     */
    public function destroy(Product $product, ProductColor $color): RedirectResponse
    {
        $color->delete();
        return $this->showMessageWithRedirect('رنگ شما با موفقیت حذف شد', params: [$product]);
    }

    /**
     * @param ProductColor $color
     * @return JsonResponse
     */
    public function status(ProductColor $color): JsonResponse
    {
        return ShareService::ajaxChangeModelSpecialField($color);
    }
}

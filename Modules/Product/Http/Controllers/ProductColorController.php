<?php

namespace Modules\Product\Http\Controllers;


use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\ACL\Entities\Permission;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\Color;
use Modules\Product\Entities\ProductColor;
use Modules\Product\Http\Requests\ProductColorRequest;
use Modules\Product\Repositories\Color\ColorRepoEloquentInterface;
use Modules\Product\Repositories\ProductColor\ProductColorRepoEloquentInterface;
use Modules\Product\Services\ProductColor\ProductColorService;
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
    private string $class = Color::class;

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

        $this->middleware('can:' . Permission::PERMISSION_PRODUCT_COLORS)->only(['index']);
        $this->middleware('can:' . Permission::PERMISSION_PRODUCT_COLOR_CREATE)->only(['create', 'store']);
        $this->middleware('can:' . Permission::PERMISSION_PRODUCT_COLOR_EDIT)->only(['edit', 'update']);
        $this->middleware('can:' . Permission::PERMISSION_PRODUCT_COLOR_DELETE)->only(['destroy']);
        $this->middleware('can:' . Permission::PERMISSION_PRODUCT_COLOR_STATUS)->only(['status']);
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

        return view('Product::admin.product-color.index', compact(['product', 'colors']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Product $product
     * @param ColorRepoEloquentInterface $colorRepo
     * @return Application|Factory|View
     */
    public function create(Product $product, ColorRepoEloquentInterface $colorRepo): View|Factory|Application
    {
        $colors = $colorRepo->getLatest()->get()->except($product->colors()->pluck('color_id')->toArray());
        return view('Product::admin.product-color.create', compact(['product', 'colors']));
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
        $color = $this->service->store($request, $product->id);
        ShareService::ProductColorWarehouseReport($request, $product, $color);
        return $this->showMessageWithRedirectRoute('رنگ شما با موفقیت ثبت شد', params: [$product]);
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
     * @param ColorRepoEloquentInterface $colorRepo
     * @return Application|Factory|View
     */
    public function edit(Product $product, ProductColor $color, ColorRepoEloquentInterface $colorRepo): Application|Factory|View
    {
        $colors = $colorRepo->getLatest()->get()->except($product->colors()->get()->except($color->id)->pluck('color_id')->toArray());
        return view('Product::admin.product-color.edit', compact(['product', 'color', 'colors']));
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
        ShareService::ProductColorWarehouseReport($request, $product, $color, event: 'update');
        return $this->showMessageWithRedirectRoute('رنگ شما با موفقیت ویرایش شد', params: [$product]);
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
        return $this->showMessageWithRedirectRoute('رنگ شما با موفقیت حذف شد', params: [$product]);
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

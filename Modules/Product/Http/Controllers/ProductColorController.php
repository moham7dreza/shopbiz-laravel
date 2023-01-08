<?php

namespace Modules\Product\Http\Controllers;


use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\ProductColor;
use Modules\Product\Repositories\Color\ProductColorRepoEloquentInterface;
use Modules\Product\Services\Color\ProductColorService;
use Modules\Share\Http\Controllers\Controller;

class ProductColorController extends Controller
{
    private string $redirectRoute = 'product-color.index';

    private string $class = ProductColor::class;

    public ProductColorRepoEloquentInterface $repo;
    public ProductColorService $service;

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
     * @return Application|Factory|View
     */
    public function index(Product $product)
    {
        return view('Product::admin.color.index', compact('product'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(Product $product)
    {
        return view('Product::admin.color.create', compact('product'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param Product $product
     * @return RedirectResponse
     */
    public function store(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'color_name' => 'required|max:120|min:2|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي., ]+$/u',
            'color' => 'required|max:120',
            'price_increase' => 'required|numeric',
        ]);
        $inputs = $request->all();
            $inputs['product_id'] = $product->id;
            $color = ProductColor::query()->create($inputs);
            return redirect()->route('product.color.index', $product->id)->with('swal-success', 'رنگ شما با موفقیت ثبت شد');
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort(403);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        abort(403);
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
        return back();
    }
}

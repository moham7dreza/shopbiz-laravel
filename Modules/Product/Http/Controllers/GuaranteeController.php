<?php

namespace Modules\Product\Http\Controllers;


use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\Product\Entities\Guarantee;
use Modules\Product\Entities\Product;
use Modules\Product\Repositories\Guarantee\ProductGuaranteeRepoEloquentInterface;
use Modules\Product\Services\Guarantee\ProductGuaranteeService;
use Modules\Share\Http\Controllers\Controller;

class GuaranteeController extends Controller
{
    private string $redirectRoute = 'product-guarantee.index';

    private string $class = Guarantee::class;

    public ProductGuaranteeRepoEloquentInterface $repo;
    public ProductGuaranteeService $service;

    public function __construct(ProductGuaranteeRepoEloquentInterface $guaranteeRepoEloquent, ProductGuaranteeService $guaranteeService)
    {
        $this->repo = $guaranteeRepoEloquent;
        $this->service = $guaranteeService;

        $this->middleware('can:permission-product-guarantees')->only(['index']);
        $this->middleware('can:permission-product-guarantee-create')->only(['create', 'store']);
        $this->middleware('can:permission-product-guarantee-delete')->only(['destroy']);
    }
    /**
     * @param Product $product
     * @return Application|Factory|View
     */
    public function index(Product $product)
    {
        return view('Product::admin.guarantee.index', compact('product'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(Product $product)
    {
        return view('Product::admin.guarantee.create', compact('product'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param Product $product
     * @return RedirectResponse
     */
    public function store(Request $request, Product $product): \Illuminate\Http\RedirectResponse
    {
        $validated = $request->validate([
                'name'              =>  'required',
                'price_increase'    =>  'required|numeric'
        ]);
        $inputs = $request->all();
        $inputs['product_id'] = $product->id;
        $guarantee = Guarantee::query()->create($inputs);
        return redirect()->route('product.guarantee.index', $product->id)->with('swal-success', 'گارانتی شما با موفقیت ثبت شد');
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
     * @param Guarantee $guarantee
     * @return RedirectResponse
     */
    public function destroy(Product $product, Guarantee $guarantee): RedirectResponse
    {
        $guarantee->delete();
        return back();
    }
}

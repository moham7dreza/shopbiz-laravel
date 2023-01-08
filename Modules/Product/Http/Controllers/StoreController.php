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
use Modules\Share\Http\Controllers\Controller;

class StoreController extends Controller
{

    private string $redirectRoute = 'product-store.index';

    private string $class = Product::class;
    public function __construct()
    {
        $this->middleware('can:permission-product-warehouse')->only(['index']);
        $this->middleware('can:permission-product-warehouse-add')->only(['addToStore', 'store']);
        $this->middleware('can:permission-product-warehouse-modify')->only(['edit', 'update']);
    }

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $products = Product::query()->orderBy('created_at', 'desc')->simplePaginate(15);
        return view('Product::admin.store.index', compact('products'));
    }


    /**
     * @param Product $product
     * @return Application|Factory|View
     */
    public function addToStore(Product $product)
    {
        return view('Product::admin.store.add-to-store', compact('product'));
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
        $product->marketable_number += $request->marketable_number;
        $product->save();
        Log::info("receiver => {$request->receiver}, deliverer => {$request->deliverer}, description => {$request->description}, add => {$request->marketable_number}");
        return redirect()->route('product.store.index')->with('swal-success', 'مجودی جدید با موفقیت ثبت شد');
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
    public function edit(Product $product)
    {
        return view('Product::admin.store.edit', compact('product'));
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
        $inputs = $request->all();
        $product->update($inputs);
        return redirect()->route('product.store.index')->with('swal-success', 'موجودی  با موفقیت ویرایش شد');
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

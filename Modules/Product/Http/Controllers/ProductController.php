<?php

namespace Modules\Product\Http\Controllers;


use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Modules\Brand\Entities\Brand;
use Modules\Category\Entities\ProductCategory;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\ProductMeta;
use Modules\Product\Http\Requests\ProductRequest;
use Modules\Product\Repositories\Product\ProductRepoEloquentInterface;
use Modules\Product\Services\Product\ProductService;
use Modules\Share\Http\Controllers\Controller;
use Modules\Share\Http\Services\Image\ImageService;

class ProductController extends Controller
{
    private string $redirectRoute = 'product.index';

    private string $class = Product::class;

    public ProductRepoEloquentInterface $repo;
    public ProductService $service;

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
        return view('Product::admin.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(): View|Factory|Application
    {
        $productCategories = ProductCategory::all();
        $brands = Brand::all();
        return view('Product::admin.create', compact('productCategories', 'brands'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProductRequest $request
     * @param ImageService $imageService
     * @return RedirectResponse
     */
    public function store(ProductRequest $request, ImageService $imageService): \Illuminate\Http\RedirectResponse
    {

        $inputs = $request->all();

        //date fixed
        $realTimestampStart = substr($request->published_at, 0, 10);
        $inputs['published_at'] = date("Y-m-d H:i:s", (int)$realTimestampStart);

        if ($request->hasFile('image')) {
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'product');
            $result = $imageService->createIndexAndSave($request->file('image'));
            if ($result === false) {
                return redirect()->route('product.index')->with('swal-error', 'آپلود تصویر با خطا مواجه شد');
            }
            $inputs['image'] = $result;
        }

        DB::transaction(function () use ($request, $inputs) {

            $product = Product::query()->create($inputs);
            $metas = array_combine($request->meta_key, $request->meta_value);
            foreach ($metas as $key => $value) {
                $meta = ProductMeta::query()->create([
                    'meta_key' => $key,
                    'meta_value' => $value,
                    'product_id' => $product->id
                ]);
            }
        });

        return redirect()->route('product.index')->with('swal-success', 'محصول  جدید شما با موفقیت ثبت شد');
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
     * @return Application|Factory|View
     */
    public function edit(Product $product): View|Factory|Application
    {
        $productCategories = ProductCategory::all();
        $brands = Brand::all();
        return view('Product::admin.edit', compact('product', 'productCategories', 'brands'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProductRequest $request
     * @param Product $product
     * @param ImageService $imageService
     * @return RedirectResponse
     */
    public function update(ProductRequest $request, Product $product, ImageService $imageService): RedirectResponse
    {
        $inputs = $request->all();
        //date fixed
        $realTimestampStart = substr($request->published_at, 0, 10);
        $inputs['published_at'] = date("Y-m-d H:i:s", (int)$realTimestampStart);

        if ($request->hasFile('image')) {
            if (!empty($product->image)) {
                $imageService->deleteDirectoryAndFiles($product->image['directory']);
            }
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'product');
            $result = $imageService->createIndexAndSave($request->file('image'));
            if ($result === false) {
                return redirect()->route('product.index')->with('swal-error', 'آپلود تصویر با خطا مواجه شد');
            }
            $inputs['image'] = $result;
        } else {
            if (isset($inputs['currentImage']) && !empty($product->image)) {
                $image = $product->image;
                $image['currentImage'] = $inputs['currentImage'];
                $inputs['image'] = $image;
            }
        }

        DB::transaction(function () use ($request, $inputs, $product) {
            $product->update($inputs);
            if ($request->meta_key != null) {
                $meta_keys = $request->meta_key;
                $meta_values = $request->meta_value;
                $meta_ids = array_keys($request->meta_key);
                $metas = array_map(function ($meta_id, $meta_key, $meta_value) {
                    return array_combine(
                        ['meta_id', 'meta_key', 'meta_value'],
                        [$meta_id, $meta_key, $meta_value]
                    );
                }, $meta_ids, $meta_keys, $meta_values);
                foreach ($metas as $meta) {
                    ProductMeta::query()->where('id', $meta['meta_id'])->update(
                        ['meta_key' => $meta['meta_key'], 'meta_value' => $meta['meta_value']]
                    );
                }
            }
        });

        return redirect()->route('product.index')->with('swal-success', 'محصول  شما با موفقیت ویرایش شد');
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
        return redirect()->route('product.index')->with('swal-success', 'محصول شما با موفقیت حذف شد');
    }
}

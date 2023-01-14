<?php

namespace Modules\Product\Http\Controllers;


use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\Product\Entities\Gallery;
use Modules\Product\Entities\Product;
use Modules\Product\Repositories\Gallery\ProductGalleryRepoEloquentInterface;
use Modules\Product\Services\Gallery\ProductGalleryService;
use Modules\Share\Http\Controllers\Controller;
use Modules\Share\Http\Services\Image\ImageService;

class GalleryController extends Controller
{
    /**
     * @var string
     */
    private string $redirectRoute = 'product-gallery.index';

    /**
     * @var string
     */
    private string $class = Gallery::class;

    public ProductGalleryRepoEloquentInterface $repo;
    public ProductGalleryService $service;

    /**
     * @param ProductGalleryRepoEloquentInterface $galleryRepoEloquent
     * @param ProductGalleryService $galleryService
     */
    public function __construct(ProductGalleryRepoEloquentInterface $galleryRepoEloquent, ProductGalleryService $galleryService)
    {
        $this->repo = $galleryRepoEloquent;
        $this->service = $galleryService;

        $this->middleware('can:permission-product-gallery')->only(['index']);
        $this->middleware('can:permission-product-gallery-create')->only(['create', 'store']);
        $this->middleware('can:permission-product-gallery-delete')->only(['destroy']);
    }
    /**
     * @param Product $product
     * @return Application|Factory|View
     */
    public function index(Product $product): Factory|View|Application
    {
        $images = $product->images()->paginate(10);
        return view('Product::admin.gallery.index', compact(['product', 'images']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Product $product
     * @return Application|Factory|View
     */
    public function create(Product $product): View|Factory|Application
    {
        return view('Product::admin.gallery.create', compact('product'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param Product $product
     * @param ImageService $imageService
     * @return RedirectResponse
     */
    public function store(Request $request, Product $product, ImageService $imageService): \Illuminate\Http\RedirectResponse
    {
        $validated = $request->validate([
            'image' => 'required|image|mimes:png,jpg,jpeg,gif',
        ]);
        $inputs = $request->all();
        if ($request->hasFile('image')) {
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'product-gallery');
            $result = $imageService->createIndexAndSave($request->file('image'));
            if ($result === false) {
                return redirect()->route('product.gallery.index', $product->id)->with('swal-error', 'آپلود تصویر با خطا مواجه شد');
            }
            $inputs['image'] = $result;
            $inputs['product_id'] = $product->id;
            $gallery = Gallery::query()->create($inputs);
            return redirect()->route('product.gallery.index', $product->id)->with('swal-success', 'عکس شما با موفقیت ثبت شد');
        } else {
            return back();
        }
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
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort(403);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
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
     * @param Gallery $gallery
     * @return RedirectResponse
     */
    public function destroy(Product $product, Gallery $gallery): RedirectResponse
    {
        $result = $gallery->delete();
        return redirect()->route('product.gallery.index', $product->id)->with('swal-success', 'عکس شما با موفقیت حذف شد');
    }
}

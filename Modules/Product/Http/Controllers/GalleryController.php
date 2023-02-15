<?php

namespace Modules\Product\Http\Controllers;


use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\Product\Entities\Gallery;
use Modules\Product\Entities\Product;
use Modules\Product\Http\Requests\ProductGalleryRequest;
use Modules\Product\Repositories\Gallery\ProductGalleryRepoEloquentInterface;
use Modules\Product\Services\Gallery\ProductGalleryService;
use Modules\Share\Http\Controllers\Controller;
use Modules\Share\Traits\ShowMessageWithRedirectTrait;

class GalleryController extends Controller
{
    use ShowMessageWithRedirectTrait;

    /**
     * @var string
     */
    private string $redirectRoute = 'product.gallery.index';

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
     * @return Application|Factory|View|RedirectResponse
     */
    public function index(Product $product): Factory|View|Application|RedirectResponse
    {
        if (isset(request()->search)) {
            $images = $this->repo->search(request()->search)->paginate(10);
            if (count($images) > 0) {
                $this->showToastOfFetchedRecordsCount(count($images));
            } else {
                return $this->showAlertOfNotResultFound();
            }
        } else {
            $images = $product->images()->paginate(10);
        }

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
     * @param ProductGalleryRequest $request
     * @param Product $product
     * @return RedirectResponse
     */
    public function store(ProductGalleryRequest $request, Product $product): RedirectResponse
    {
        $result = $this->service->store($request, $product->id);
        if ($result == 'upload failed') {
            return $this->showMessageWithRedirectRoute('آپلود تصویر با خطا مواجه شد', 'خطا', status: 'error');
        }
        return $this->showMessageWithRedirectRoute('عکس شما با موفقیت ثبت شد', params: [$product]);
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
        return $this->showMessageWithRedirectRoute('عکس شما با موفقیت حذف شد', params: [$product]);
    }
}

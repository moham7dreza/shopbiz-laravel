<?php

namespace Modules\Brand\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Modules\Brand\Entities\Brand;
use Modules\Brand\Http\Requests\BrandRequest;
use Modules\Brand\Repositories\BrandRepoEloquentInterface;
use Modules\Brand\Services\BrandService;
use Modules\Share\Http\Controllers\Controller;
use Modules\Share\Http\Services\Image\ImageService;

class BrandController extends Controller
{
    /**
     * @var string
     */
    private string $redirectRoute = 'brand.index';

    /**
     * @var string
     */
    private string $class = Brand::class;

    public BrandRepoEloquentInterface $repo;
    public BrandService $service;

    /**
     * @param BrandRepoEloquentInterface $brandRepoEloquent
     * @param BrandService $brandService
     */
    public function __construct(BrandRepoEloquentInterface $brandRepoEloquent, BrandService $brandService)
    {
        $this->repo = $brandRepoEloquent;
        $this->service = $brandService;

        $this->middleware('can:permission-product-brands')->only(['index']);
        $this->middleware('can:permission-product-brand-create')->only(['create', 'store']);
        $this->middleware('can:permission-product-brand-edit')->only(['edit', 'update']);
        $this->middleware('can:permission-product-brand-delete')->only(['destroy']);
        $this->middleware('can:permission-product-brand-status')->only(['status']);

    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): View|Factory|Application
    {
        $brands = $this->repo->index()->paginate(10);
        return view('Brand::index', compact(['brands']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(): View|Factory|Application
    {
        return view('Brand::create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param BrandRequest $request
     * @param ImageService $imageService
     * @return RedirectResponse
     */
    public function store(BrandRequest $request, ImageService $imageService): RedirectResponse
    {
        $inputs = $request->all();
        if ($request->hasFile('logo')) {
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'brand');
            $result = $imageService->createIndexAndSave($request->file('logo'));
            if ($result === false) {
                return redirect()->route('brand.index')->with('swal-error', 'آپلود تصویر با خطا مواجه شد');
            } else {
                $inputs['logo'] = $result;
            }
        }
        $brand = Brand::query()->create($inputs);
        return redirect()->route('brand.index')->with('swal-success', 'برند جدید شما با موفقیت ثبت شد');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show(int $id): Response
    {
        abort(403);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Brand $brand
     * @return Application|Factory|View
     */
    public function edit(Brand $brand): View|Factory|Application
    {
        return view('Brand::edit', compact(['brand']));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param BrandRequest $request
     * @param Brand $brand
     * @param ImageService $imageService
     * @return RedirectResponse
     */
    public function update(BrandRequest $request, Brand $brand, ImageService $imageService): RedirectResponse
    {
        $inputs = $request->all();

        if ($request->hasFile('logo')) {
            if (!empty($brand->logo)) {
                $imageService->deleteDirectoryAndFiles($brand->logo['directory']);
            }
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'brand');
            $result = $imageService->createIndexAndSave($request->file('logo'));
            if ($result === false) {
                return redirect()->route('brand.index')->with('swal-error', 'آپلود تصویر با خطا مواجه شد');
            }
            $inputs['logo'] = $result;
        } else {
            if (isset($inputs['currentImage']) && !empty($brand->logo)) {
                $image = $brand->logo;
                $image['currentImage'] = $inputs['currentImage'];
                $inputs['logo'] = $image;
            }
        }
        $brand->update($inputs);
        return redirect()->route('brand.index')->with('swal-success', 'برند شما با موفقیت ویرایش شد');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Brand $brand
     * @return RedirectResponse
     */
    public function destroy(Brand $brand): RedirectResponse
    {
        $result = $brand->delete();
        return redirect()->route('brand.index')->with('swal-success', 'برند شما با موفقیت حذف شد');
    }

    /**
     * @param Brand $brand
     * @return JsonResponse
     */
    public function status(Brand $brand): JsonResponse
    {
        $brand->status = $brand->status == 0 ? 1 : 0;
        $result = $brand->save();
        if ($result) {
            if ($brand->status == 0) {
                return response()->json(['status' => true, 'checked' => false]);
            } else {
                return response()->json(['status' => true, 'checked' => true]);
            }
        } else {
            return response()->json(['status' => false]);
        }
    }
}

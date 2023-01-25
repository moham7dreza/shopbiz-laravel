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
use Modules\Share\Services\ShareService;
use Modules\Share\Traits\ShowMessageWithRedirectTrait;

class BrandController extends Controller
{
    use ShowMessageWithRedirectTrait;

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
     * @return RedirectResponse
     */
    public function store(BrandRequest $request): RedirectResponse
    {
       $this->service->store($request);
        return $this->showMessageWithRedirect('برند جدید شما با موفقیت ثبت شد');
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
     * @return RedirectResponse
     */
    public function update(BrandRequest $request, Brand $brand): RedirectResponse
    {
        $this->service->update($request, $brand);
        return $this->showMessageWithRedirect('برند شما با موفقیت ویرایش شد');
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
        return $this->showMessageWithRedirect('برند شما با موفقیت حذف شد');
    }

    /**
     * @param Brand $brand
     * @return JsonResponse
     */
    public function status(Brand $brand): JsonResponse
    {
        return ShareService::changeStatus($brand);
    }
}

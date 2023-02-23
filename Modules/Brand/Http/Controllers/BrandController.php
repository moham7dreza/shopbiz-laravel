<?php

namespace Modules\Brand\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Modules\ACL\Entities\Permission;
use Modules\Brand\Entities\Brand;
use Modules\Brand\Http\Requests\BrandRequest;
use Modules\Brand\Repositories\BrandRepoEloquentInterface;
use Modules\Brand\Services\BrandService;
use Modules\Share\Http\Controllers\Controller;
use Modules\Share\Services\ShareService;
use Modules\Share\Traits\ShowMessageWithRedirectTrait;
use Modules\Tag\Repositories\TagRepositoryEloquentInterface;

class BrandController extends Controller
{
    use ShowMessageWithRedirectTrait;

    /**
     * @var string
     */
    public string $redirectRoute = 'brand.index';

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

        $this->middleware('can:'. Permission::PERMISSION_BRANDS)->only(['index']);
        $this->middleware('can:'. Permission::PERMISSION_BRAND_CREATE)->only(['create', 'store']);
        $this->middleware('can:'. Permission::PERMISSION_BRAND_EDIT)->only(['edit', 'update']);
        $this->middleware('can:'. Permission::PERMISSION_BRAND_DELETE)->only(['destroy']);
        $this->middleware('can:'. Permission::PERMISSION_BRAND_STATUS)->only(['status']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|RedirectResponse
     */
    public function index(): View|Factory|Application|RedirectResponse
    {
        if (isset(request()->search)) {
            $brands = $this->repo->search(request()->search)->paginate(10);
            if (count($brands) > 0) {
                $this->showToastOfFetchedRecordsCount(count($brands));
            } else {
                return $this->showAlertOfNotResultFound();
            }
        } elseif (isset(request()->sort)) {
            $brands = $this->repo->sort(request()->sort, request()->dir)->paginate(10);
            $this->showToastOfSelectedDirection(request()->dir);
        } else {
            $brands = $this->repo->index()->paginate(10);
        }
        $redirectRoute = $this->redirectRoute;
        return view('Brand::index', compact(['brands', 'redirectRoute']));
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
        $result = $this->service->store($request);
        if ($result == 'upload failed') {
            return $this->showMessageWithRedirectRoute('آپلود تصویر با خطا مواجه شد', 'خطا', status: 'error');
        }
        return $this->showMessageWithRedirectRoute('برند جدید شما با موفقیت ثبت شد');
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
        $result = $this->service->update($request, $brand);
        if ($result == 'upload failed') {
            return $this->showMessageWithRedirectRoute('آپلود تصویر با خطا مواجه شد', 'خطا', status: 'error');
        }
        return $this->showMessageWithRedirectRoute('برند شما با موفقیت ویرایش شد');
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
        return $this->showMessageWithRedirectRoute('برند شما با موفقیت حذف شد');
    }

    /**
     * @param Brand $brand
     * @return JsonResponse
     */
    public function status(Brand $brand): JsonResponse
    {
        return ShareService::changeStatus($brand);
    }

    /**
     * @param Brand $brand
     * @param TagRepositoryEloquentInterface $tagRepositoryEloquent
     * @return Application|Factory|View
     */
    public function tagsForm(Brand $brand, TagRepositoryEloquentInterface $tagRepositoryEloquent): View|Factory|Application
    {
        $tags = $tagRepositoryEloquent->index()->get();
        return view('Brand::tags-form', compact(['brand', 'tags']));
    }

    /**
     * @param BrandRequest $request
     * @param Brand $brand
     * @return RedirectResponse
     */
    public function setTags(BrandRequest $request, Brand $brand): RedirectResponse
    {
        $brand->tags()->sync($request->tags);
        return $this->showMessageWithRedirectRoute('تگ های برند با موفقیت بروزرسانی شد');
    }
}

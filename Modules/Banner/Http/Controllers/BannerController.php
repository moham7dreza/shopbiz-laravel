<?php

namespace Modules\Banner\Http\Controllers;


use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Modules\Banner\Entities\Banner;
use Modules\Banner\Http\Requests\BannerRequest;
use Modules\Banner\Repositories\BannerRepoEloquentInterface;
use Modules\Banner\Services\BannerService;
use Modules\Share\Http\Controllers\Controller;
use Modules\Share\Http\Services\Image\ImageService;
use Modules\Share\Services\ShareService;
use Modules\Share\Traits\SuccessToastMessageWithRedirectTrait;

class BannerController extends Controller
{
    use SuccessToastMessageWithRedirectTrait;

    /**
     * @var string
     */
    private string $redirectRoute = 'banner.index';

    /**
     * @var string
     */
    private string $class = Banner::class;

    public BannerRepoEloquentInterface $repo;
    public BannerService $service;

    /**
     * @param BannerRepoEloquentInterface $bannerRepoEloquent
     * @param BannerService $bannerService
     */
    public function __construct(BannerRepoEloquentInterface $bannerRepoEloquent, BannerService $bannerService)
    {
        $this->repo = $bannerRepoEloquent;
        $this->service = $bannerService;

//        $this->middleware('can:role-admin')->only(['index']);
        $this->middleware('can:permission-banners')->only(['index']);
        $this->middleware('can:permission-banner-create')->only(['create', 'store']);
        $this->middleware('can:permission-banner-edit')->only(['edit', 'update']);
        $this->middleware('can:permission-banner-delete')->only(['destroy']);
        $this->middleware('can:permission-banner-status')->only(['status']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): View|Factory|Application
    {
        $banners = $this->repo->index()->paginate(10);
        $positions = $this->repo->positions();
        return view('Banner::index', compact(['banners', 'positions']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(): View|Factory|Application
    {
        $positions = $this->repo->positions();
        return view('Banner::create', compact(['positions']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param BannerRequest $request
     * @return RedirectResponse
     */
    public function store(BannerRequest $request): RedirectResponse
    {
        $this->service->store($request);
        return $this->successMessageWithRedirect('بنر جدید شما با موفقیت ثبت شد');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     */
    public function show($id)
    {
        abort(403);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Banner $banner
     * @return Application|Factory|View
     */
    public function edit(Banner $banner): View|Factory|Application
    {
        $positions = $this->repo->positions();
        return view('Banner::edit', compact(['banner', 'positions']));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param BannerRequest $request
     * @param Banner $banner
     * @return RedirectResponse
     */
    public function update(BannerRequest $request, Banner $banner): RedirectResponse
    {
        $this->service->update($request, $banner);
        return $this->successMessageWithRedirect('بنر شما با موفقیت ویرایش شد');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Banner $banner
     * @return RedirectResponse
     */
    public function destroy(Banner $banner): RedirectResponse
    {
        $result = $banner->delete();
        return $this->successMessageWithRedirect('بنر شما با موفقیت حذف شد');
    }


    /**
     * @param Banner $banner
     * @return JsonResponse
     */
    public function status(Banner $banner): JsonResponse
    {
        return ShareService::changeStatus($banner);
    }
}

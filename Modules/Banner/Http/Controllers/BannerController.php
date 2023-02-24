<?php

namespace Modules\Banner\Http\Controllers;


use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Modules\ACL\Entities\Permission;
use Modules\Banner\Entities\Banner;
use Modules\Banner\Http\Requests\BannerRequest;
use Modules\Banner\Repositories\BannerRepoEloquentInterface;
use Modules\Banner\Services\BannerService;
use Modules\Share\Http\Controllers\Controller;
use Modules\Share\Services\ShareService;
use Modules\Share\Traits\ShowMessageWithRedirectTrait;

class BannerController extends Controller
{
    use ShowMessageWithRedirectTrait;

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
        $this->middleware('can:'. Permission::PERMISSION_BANNERS)->only(['index']);
        $this->middleware('can:'. Permission::PERMISSION_BANNER_CREATE)->only(['create', 'store']);
        $this->middleware('can:'. Permission::PERMISSION_BANNER_EDIT)->only(['edit', 'update']);
        $this->middleware('can:'. Permission::PERMISSION_BANNER_DELETE)->only(['destroy']);
        $this->middleware('can:'. Permission::PERMISSION_BANNER_STATUS)->only(['status']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return View|Factory|Application|RedirectResponse
     */
    public function index(): View|Factory|Application|RedirectResponse
    {
        if (isset(request()->search)) {
            $banners = $this->repo->search(request()->search)->paginate(10);
            if (count($banners) > 0) {
                $this->showToastOfFetchedRecordsCount(count($banners));
            } else {
                return $this->showAlertOfNotResultFound();
            }
        } elseif (isset(request()->sort)) {
            $banners = $this->repo->sort(request()->sort, request()->dir)->paginate(10);
            if (count($banners) > 0) {
                $this->showToastOfSelectedDirection(request()->dir);
            }
            $this->showToastOfNotDataExists();
        } else {
            $banners = $this->repo->index()->paginate(10);
        }
        $redirectRoute = $this->redirectRoute;
        $positions = $this->repo->positions();
        return view('Banner::index', compact(['banners', 'positions', 'redirectRoute']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View|RedirectResponse
     */
    public function create(): View|Factory|Application|RedirectResponse
    {
        $positions = $this->repo->positions();
        if (count($positions) > 0) {
            return view('Banner::create', compact(['positions']));
        }
        return $this->showMessageWithRedirectRoute(msg: 'برای ایجاد بنر ابتدا باید مکان بنرها تعریف شوند.', title: 'خطا', status: 'error');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param BannerRequest $request
     * @return RedirectResponse
     */
    public function store(BannerRequest $request): RedirectResponse
    {
        $result = $this->service->store($request);
        if ($result == 'upload failed') {
            return $this->showMessageWithRedirectRoute('آپلود تصویر با خطا مواجه شد', 'خطا', status: 'error');
        }
        return $this->showMessageWithRedirectRoute('بنر جدید شما با موفقیت ثبت شد');
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
        $result = $this->service->update($request, $banner);
        if ($result == 'upload failed') {
            return $this->showMessageWithRedirectRoute('آپلود تصویر با خطا مواجه شد', 'خطا', status: 'error');
        }
        return $this->showMessageWithRedirectRoute('بنر شما با موفقیت ویرایش شد');
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
        return $this->showMessageWithRedirectRoute('بنر شما با موفقیت حذف شد');
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

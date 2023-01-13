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

class BannerController extends Controller
{
    private string $redirectRoute = 'banner.index';

    private string $class = Banner::class;

    public BannerRepoEloquentInterface $repo;
    public BannerService $service;

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
        $banners = Banner::query()->orderBy('created_at', 'desc')->simplePaginate(15);
        $positions = Banner::$positions;
        return view('Banner::index', compact('banners', 'positions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(): View|Factory|Application
    {
        $positions = Banner::$positions;
        return view('Banner::create', compact('positions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param BannerRequest $request
     * @param ImageService $imageService
     * @return RedirectResponse
     */
    public function store(BannerRequest $request, ImageService $imageService): RedirectResponse
    {
        $inputs = $request->all();


        if ($request->hasFile('image')) {
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'banner');
            $result = $imageService->save($request->file('image'));
            if ($result === false) {
                return redirect()->route('banner.index')->with('swal-error', 'آپلود تصویر با خطا مواجه شد');
            }
            $inputs['image'] = $result;
        }
        $banner = Banner::query()->create($inputs);
        return redirect()->route('banner.index')->with('swal-success', 'بنر  جدید شما با موفقیت ثبت شد');
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
     * @param Banner $banner
     * @return Application|Factory|View
     */
    public function edit(Banner $banner): View|Factory|Application
    {
        $positions = Banner::$positions;
        return view('Banner::edit', compact('banner', 'positions'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param BannerRequest $request
     * @param Banner $banner
     * @param ImageService $imageService
     * @return RedirectResponse
     */
    public function update(BannerRequest $request, Banner $banner, ImageService $imageService): RedirectResponse
    {
        $inputs = $request->all();
        if ($request->hasFile('image')) {
            if (!empty($banner->image)) {
                $imageService->deleteImage($banner->image);
            }
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'banner');
            $result = $imageService->save($request->file('image'));

            if ($result === false) {
                return redirect()->route('banner.index')->with('swal-error', 'آپلود تصویر با خطا مواجه شد');
            }
            $inputs['image'] = $result;
        } else {
            if (isset($inputs['currentImage']) && !empty($banner->image)) {
                $image = $banner->image;
                $image['currentImage'] = $inputs['currentImage'];
                $inputs['image'] = $image;
            }
        }
        $banner->update($inputs);
        return redirect()->route('banner.index')->with('swal-success', 'بنر  شما با موفقیت ویرایش شد');
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
        return redirect()->route('banner.index')->with('swal-success', 'بنر  شما با موفقیت حذف شد');
    }


    /**
     * @param Banner $banner
     * @return JsonResponse
     */
    public function status(Banner $banner): JsonResponse
    {
        $banner->status = $banner->status == 0 ? 1 : 0;
        $result = $banner->save();
        if ($result) {
            if ($banner->status == 0) {
                return response()->json(['status' => true, 'checked' => false]);
            } else {
                return response()->json(['status' => true, 'checked' => true]);
            }
        } else {
            return response()->json(['status' => false]);
        }
    }

}

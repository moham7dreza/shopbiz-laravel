<?php

namespace Modules\Banner\Http\Controllers\Api;

use Modules\Banner\Http\Resources\BannerResource;
use Modules\Banner\Repositories\BannerRepoEloquentInterface;
use Modules\Banner\Services\BannerService;
use Modules\Share\Http\Controllers\Controller;

class ApiBannerController extends Controller
{
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
    }

    /**
     * @return BannerResource
     */
    public function index(): BannerResource
    {
        $banners = $this->repo->index()->get();
        return new BannerResource($banners);
    }
}

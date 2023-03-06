<?php

namespace Modules\Brand\Http\Controllers\Api;

use Modules\Brand\Http\Resources\BrandResource;
use Modules\Brand\Repositories\BrandRepoEloquentInterface;
use Modules\Brand\Services\BrandService;
use Modules\Share\Http\Controllers\Controller;

class ApiBrandController extends Controller
{
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
    }

    /**
     * @return BrandResource
     */
    public function index(): BrandResource
    {
        $brands = $this->repo->index()->get();
        return new BrandResource($brands);
    }
}

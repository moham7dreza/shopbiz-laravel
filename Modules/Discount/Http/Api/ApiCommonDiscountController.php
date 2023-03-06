<?php

namespace Modules\Discount\Http\Api;

use Modules\Discount\Http\Resources\CommonDiscountResource;
use Modules\Discount\Repositories\Common\CommonDiscountRepoEloquentInterface;
use Modules\Discount\Services\Common\CommonDiscountService;
use Modules\Share\Http\Controllers\Controller;

class ApiCommonDiscountController extends Controller
{
    public CommonDiscountRepoEloquentInterface $repo;
    public CommonDiscountService $service;

    /**
     * @param CommonDiscountRepoEloquentInterface $repo
     * @param CommonDiscountService $service
     */
    public function __construct(CommonDiscountRepoEloquentInterface $repo, CommonDiscountService $service)
    {
        $this->repo = $repo;
        $this->service = $service;
    }

    /**
     * @return CommonDiscountResource
     */
    public function index(): CommonDiscountResource
    {
        $commons = $this->repo->getLatestOrderByDate()->get();
        return new CommonDiscountResource($commons);
    }
}

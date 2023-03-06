<?php

namespace Modules\Discount\Http\Api;

use Modules\Discount\Http\Resources\AmazingSaleResource;
use Modules\Discount\Repositories\AmazingSale\AmazingSaleDiscountRepoEloquentInterface;
use Modules\Discount\Services\AmazingSale\AmazingSaleDiscountService;
use Modules\Product\Repositories\Product\ProductRepoEloquentInterface;
use Modules\Share\Http\Controllers\Controller;

class ApiAmazingSaleController extends Controller
{
    public AmazingSaleDiscountRepoEloquentInterface $repo;
    public AmazingSaleDiscountService $service;
    public ProductRepoEloquentInterface $productRepo;

    /**
     * @param AmazingSaleDiscountRepoEloquentInterface $repo
     * @param AmazingSaleDiscountService $service
     * @param ProductRepoEloquentInterface $productRepo
     */
    public function __construct(AmazingSaleDiscountRepoEloquentInterface $repo, AmazingSaleDiscountService $service,
                                ProductRepoEloquentInterface $productRepo)
    {
        $this->repo = $repo;
        $this->service = $service;
        $this->productRepo = $productRepo;
    }

    /**
     * @return AmazingSaleResource
     */
    public function index(): AmazingSaleResource
    {
        $sales = $this->repo->getLatestOrderByDate()->get();
        return new AmazingSaleResource($sales);
    }
}

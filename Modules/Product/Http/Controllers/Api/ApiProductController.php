<?php

namespace Modules\Product\Http\Controllers\Api;

use Modules\Product\Http\Resources\ProductResource;
use Modules\Product\Repositories\Product\ProductRepoEloquentInterface;
use Modules\Product\Services\Product\ProductServiceInterface;
use Modules\Share\Http\Controllers\Controller;

class ApiProductController extends Controller
{
    public ProductRepoEloquentInterface $repo;
    public ProductServiceInterface $service;

    /**
     * @param ProductRepoEloquentInterface $productRepoEloquent
     * @param ProductServiceInterface $productService
     */
    public function __construct(ProductRepoEloquentInterface $productRepoEloquent, ProductServiceInterface $productService)
    {
        $this->repo = $productRepoEloquent;
        $this->service = $productService;
    }

    /**
     * @return ProductResource
     */
    public function index(): ProductResource
    {
        $products = $this->repo->index()->get();
        return new ProductResource($products);
    }

    public function search()
    {
        $result = $this->repo->search(request()->name)->get();
//        if (count($result) > 0) {
            return new ProductResource($result);
//        }
    }
}

<?php

namespace Modules\Category\Http\Controllers\Api;

use Modules\Banner\Http\Resources\BannerResource;
use Modules\Banner\Repositories\BannerRepoEloquentInterface;
use Modules\Banner\Services\BannerService;
use Modules\Category\Http\Resources\ProductCategoryResource;
use Modules\Category\Repositories\ProductCategory\ProductCategoryRepoEloquentInterface;
use Modules\Category\Services\ProductCategory\ProductCategoryServiceInterface;
use Modules\Share\Http\Controllers\Controller;

class ApiProductCategoryController extends Controller
{
    public ProductCategoryRepoEloquentInterface $categoryRepo;
    public ProductCategoryServiceInterface $categoryService;

    /**
     * @param ProductCategoryRepoEloquentInterface $productCategoryRepo
     * @param ProductCategoryServiceInterface $productCategoryService
     */
    public function __construct(ProductCategoryRepoEloquentInterface $productCategoryRepo, ProductCategoryServiceInterface $productCategoryService)
    {
        $this->categoryRepo = $productCategoryRepo;
        $this->categoryService = $productCategoryService;
    }

    /**
     * @return ProductCategoryResource
     */
    public function index(): ProductCategoryResource
    {
        $banners = $this->categoryRepo->getLatestCategories()->get();
        return new ProductCategoryResource($banners);
    }
}

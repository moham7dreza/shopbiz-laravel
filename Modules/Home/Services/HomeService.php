<?php

namespace Modules\Home\Services;

use Illuminate\Http\JsonResponse;
use Modules\Brand\Entities\Brand;
use Modules\Brand\Repositories\BrandRepoEloquentInterface;
use Modules\Category\Entities\ProductCategory;
use Modules\Category\Repositories\ProductCategory\ProductCategoryRepoEloquentInterface;
use Modules\Product\Entities\Product;
use Modules\Product\Repositories\Product\ProductRepoEloquent;
use Modules\Product\Repositories\Product\ProductRepoEloquentInterface;

class HomeService
{
    public ProductRepoEloquentInterface $productRepo;
    public ProductCategoryRepoEloquentInterface $productCategoryRepo;

    public BrandRepoEloquentInterface $brandRepo;

    public function __construct(ProductRepoEloquentInterface $productRepo, ProductCategoryRepoEloquentInterface $categoryRepo
        , BrandRepoEloquentInterface                         $brandRepo)
    {
        $this->productRepo = $productRepo;
        $this->productCategoryRepo = $categoryRepo;
        $this->brandRepo = $brandRepo;
    }


    /**
     * @param $name
     * @return JsonResponse|void
     */
    public function search($name)
    {
        if (isset($name) && strlen($name) > 0) {
            $results = collect();
            $productResults = $this->productRepo->searchByCol('name', $name)->get();
            if (count($productResults) > 0) {
                $results->put('products', $productResults);
            }
            $productCategoryResults = $this->productCategoryRepo->searchByCol('name', $name)->get();
            if (count($productCategoryResults) > 0) {
                $results->put('categories', $productCategoryResults);
            }
            $brandResults = $this->brandRepo->searchByCol('persian_name', $name)->get();
            if (count($brandResults) > 0) {
                $results->put('brands', $brandResults);
            }
            $results = $results->unique();
            if (count($results) > 0) {
                return response()->json(['status' => true, 'results' => $results, 'key' => $name]);
            } else {
                return response()->json(['status' => false, 'results' => null, 'key' => $name]);
            }
        }
    }
}

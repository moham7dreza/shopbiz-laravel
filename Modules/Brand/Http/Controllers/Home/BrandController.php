<?php

namespace Modules\Brand\Http\Controllers\Home;

use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Modules\Attribute\Entities\AttributeValue;
use Modules\Brand\Entities\Brand;
use Modules\Brand\Repositories\BrandRepoEloquentInterface;
use Modules\Category\Repositories\ProductCategory\ProductCategoryRepoEloquentInterface;
use Modules\Product\Entities\Product;
use Modules\Share\Http\Controllers\Controller;

class BrandController extends Controller
{
    public BrandRepoEloquentInterface $brandRepo;
    public ProductCategoryRepoEloquentInterface $productCategoryRepo;

    /**
     * @param BrandRepoEloquentInterface $brandRepo
     */
    public function __construct(BrandRepoEloquentInterface $brandRepo, ProductCategoryRepoEloquentInterface $productCategoryRepo)
    {
        $this->brandRepo = $brandRepo;
        $this->productCategoryRepo = $productCategoryRepo;
    }

    /**
     * @param Brand $brand
     * @return Application|Factory|View
     */
    public function brandProducts(Brand $brand): View|Factory|Application
    {
        $type = null;
        $selectedBrands = null;
        $selectedValues = null;
        $selectedPriceFrom = null;
        $selectedPriceTo = null;

        $this->setMetasForBrandPage($brand);
        $products = $brand->products()->readyForSale()->latest()->paginate(9);

        // get all products brands
        $brands = $brand->products()->with('brand')->latest()->get()->pluck('brand')->unique();
        // get all product ids for check products is in cart or not
        $userCartItemsProductIds = auth()->user()->cartItems()->pluck('product_id')->all();
        // get all cats
        $categories = $this->productCategoryRepo->getShowInMenuActiveParentCategories()->get();

        return view('Brand::home.brand-products.index', compact([
            'products', 'brand', 'brands', 'userCartItemsProductIds', 'categories', 'type',
            'selectedBrands', 'selectedValues', 'selectedPriceFrom', 'selectedPriceTo'
        ]));
    }

    /**
     * @param $brand
     * @return void
     */
    private function setMetasForBrandPage($brand): void
    {
        SEOMeta::setKeywords($brand->tags ?? '');
        SEOTools::setTitle($brand->persian_name);
        SEOTools::setDescription($brand->origianl_name);
        SEOTools::opengraph()->setUrl('http://current.url.com');
        SEOTools::setCanonical('https://codecasts.com.br/lesson');
        SEOTools::opengraph()->addProperty('type', 'articles');
        SEOTools::twitter()->setSite('@LuizVinicius73');
        SEOTools::jsonLd()->addImage('https://codecasts.com.br/img/logo.jpg');
    }
}

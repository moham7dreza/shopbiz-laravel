<?php

namespace Modules\Category\Http\Controllers\Home;

use CategoryAttribute;
use CategoryValue;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Modules\Brand\Entities\Brand;
use Modules\Brand\Repositories\BrandRepoEloquentInterface;
use Modules\Cart\Repositories\CartRepoEloquentInterface;
use Modules\Category\Entities\ProductCategory;
use Modules\Category\Repositories\ProductCategory\ProductCategoryRepoEloquentInterface;
use Modules\Category\Services\ProductCategory\ProductCategoryServiceInterface;
use Modules\Discount\Repositories\AmazingSale\AmazingSaleDiscountRepoEloquentInterface;
use Modules\Product\Entities\Product;
use Modules\Product\Repositories\Product\ProductRepoEloquentInterface;
use Modules\Share\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public BrandRepoEloquentInterface $brandRepo;
    public ProductRepoEloquentInterface $productRepo;
    public ProductCategoryRepoEloquentInterface $productCategoryRepo;
    public ProductCategoryServiceInterface $productCategoryService;
    public AmazingSaleDiscountRepoEloquentInterface $amazingSaleRepo;
    public CartRepoEloquentInterface $cartRepo;

    /**
     * @param BrandRepoEloquentInterface $brandRepoEloquent
     * @param AmazingSaleDiscountRepoEloquentInterface $amazingSaleDiscountRepoEloquent
     * @param ProductRepoEloquentInterface $productRepoEloquent
     * @param ProductCategoryRepoEloquentInterface $productCategoryRepoEloquent
     * @param CartRepoEloquentInterface $cartRepo
     * @param ProductCategoryServiceInterface $productCategoryService
     */
    public function __construct(BrandRepoEloquentInterface               $brandRepoEloquent,
                                AmazingSaleDiscountRepoEloquentInterface $amazingSaleDiscountRepoEloquent,
                                ProductRepoEloquentInterface             $productRepoEloquent,
                                ProductCategoryRepoEloquentInterface     $productCategoryRepoEloquent,
                                CartRepoEloquentInterface                $cartRepo,
                                ProductCategoryServiceInterface          $productCategoryService)
    {
        $this->brandRepo = $brandRepoEloquent;
        $this->amazingSaleRepo = $amazingSaleDiscountRepoEloquent;
        $this->productRepo = $productRepoEloquent;
        $this->productCategoryRepo = $productCategoryRepoEloquent;
        $this->cartRepo = $cartRepo;
        $this->productCategoryService = $productCategoryService;
    }

    /**
     * @param ProductCategory $productCategory
     * @return Application|Factory|View
     */
    public function categoryProducts(ProductCategory $productCategory): Factory|View|Application
    {
        // sort items by type of them
        if (isset(request()->type)) {
            $products = $this->productCategoryService->findCategoryProductsByType($productCategory, request()->type)->paginate(9);
        }   // search in items
        elseif (isset(request()->category_products_search)) {
            $products = $this->productCategoryService->findCategoryProductsByType($productCategory, request()->category_products_search)->paginate(9);
        }   // filter items by brand attrs and price
        elseif (isset(request()->brands) || isset(request()->attrs) || isset(request()->price_from) || isset(request()->price_to)) {
            $products = $this->productCategoryService->findCategoryProductsByFilter($productCategory, request()->brands,
                request()->attrs, request()->price_from, request()->price_to)->paginate(9);
        } else {
            $products = $productCategory->products()->latest()->paginate(9);
        }
        // get all products brands
        $brands = $productCategory->products()->with('brand')->latest()->get()->pluck('brand')->unique();
        // get all product ids for check products is in cart or not
        $userCartItemsProductIds = $this->cartRepo->findUserCartItems()->pluck('product_id')->all();
        // get all cats
        $categories = $this->productCategoryRepo->getShowInMenuActiveParentCategories()->get();
        return view('Category::home.category-products.index', compact([
            'productCategory', 'products', 'brands', 'userCartItemsProductIds', 'categories'
        ]));
    }

    /**
     * @return Application|Factory|View
     */
    public function bestOffers(): View|Factory|Application
    {
        $type = null;
        $selectedBrands = null;
        $selectedValues = null;
        $selectedPriceFrom = null;
        $selectedPriceTo = null;
        $productIds = $this->amazingSaleRepo->bestOffers(1)->pluck('product_id')->unique();
        // sort items by type of them
        if (isset(request()->type)) {
            $type = request()->type;
            $products = $this->productCategoryService->findOfferedProductsByType($productIds, $type)->paginate(9);
        }   // search in items
        elseif (isset(request()->products_search)) {
            $type = request()->products_search;
            $products = $this->productCategoryService->findOfferedProductsByType($productIds, $type)->paginate(9);
        }   // filter items by brand attrs and price
        elseif (isset(request()->brands) || isset(request()->values) || isset(request()->price_from) || isset(request()->price_to)) {
            if (isset(request()->brands)) {
                $selectedBrands = Brand::query()->whereIn('id', request()->brands)->pluck('persian_name');
                $selectedBrands = implode(', ', $selectedBrands->toArray());
            }
            if (isset(request()->values)) {
                $selectedValues = CategoryValue::query()->whereIn('id', request()->values)->with('attribute')->get();
                $values = [];
                foreach ($selectedValues as $selectedValue) {
                    $values[] = convertEnglishToPersian(json_decode($selectedValue->value)->value) . $selectedValue->attribute->unit;
                }
                $selectedValues = implode(', ', $values);
            }
            $selectedPriceFrom = priceFormat(request()->price_from);
            $selectedPriceTo = priceFormat(request()->price_to);
            $products = $this->productCategoryService->findOfferedProductsByFilter(
                $productIds,
                request()->brands,
                request()->values,
                request()->price_from,
                request()->price_to
            )->paginate(9);
        } else {
            $products = $this->amazingSaleRepo->bestOffers(1)->with('product')->latest()->get()->pluck('product')->unique();
        }

        // brands
        $brands = Product::query()->whereIn('id', $productIds)->with('brand')->latest()->get()->pluck('brand')->unique();
        // get all products brands
        $userCartItemsProductIds = $this->cartRepo->findUserCartItems()->pluck('product_id')->all();
        // all cats
        $categories = $this->productCategoryRepo->getShowInMenuActiveParentCategories()->get();
        // attrs and values
        $productCategoryIds = Product::query()->whereIn('id', $productIds)->pluck('category_id')->unique();
        $categoryAttrs = CategoryAttribute::query()->whereIn('category_id', $productCategoryIds)->latest()->get();
        return view('Category::home.special-sales.index', compact([
            'products', 'categories', 'userCartItemsProductIds', 'brands', 'categoryAttrs', 'type',
            'selectedBrands', 'selectedValues', 'selectedPriceFrom', 'selectedPriceTo'
        ]));
    }

    /**
     * @return Application|Factory|View
     */
    public function queryProducts(): View|Factory|Application
    {
        // برندها
        $brands = $this->brandRepo->index()->get();
        $queryResult = $queryTitle = null;
        if (isset(request()->inputQuery)) {
            switch (request()->inputQuery) {
                case 'productsWithActiveAmazingSales':
                    $queryTitle = 'محصولات فروش ویژه';
                    $amazingSales = $this->amazingSaleRepo->bestOffers()->get();
                    $queryResult = collect();
                    foreach ($amazingSales as $amazingSale) {
                        $queryResult->push($amazingSale->product);
                    }
                    break;
                case 'mostVisitedProducts':
                    $queryTitle = 'پربازدبدترین کالاها';
                    // پربازدید ترین کالاها
                    $queryResult = $this->productRepo->index()->take(10)->get();
                    break;
                case 'offerProducts':
                    $queryTitle = 'محصولات پیشنهادی';
                    // کالاهای پیشنهادی
                    $queryResult = $this->productRepo->index()->take(10)->get();
                    break;
                case 'newestProducts':
                    $queryTitle = 'جدیدترین محصولات';
                    $queryResult = $this->productRepo->index()->take(10)->get();
                    break;
                default:

            }
        }
        $productCategory = count($queryResult) == 0 ?
            $this->productCategoryRepo->findById(1) :
            $queryResult[0]->category;

        return view('Category::home.query-products',
            compact(['queryResult', 'queryTitle', 'brands', 'productCategory']));
    }
}

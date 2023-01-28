<?php

namespace Modules\Category\Http\Controllers\Home;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Modules\Brand\Repositories\BrandRepoEloquentInterface;
use Modules\Cart\Repositories\CartRepoEloquentInterface;
use Modules\Category\Entities\ProductCategory;
use Modules\Category\Repositories\ProductCategory\ProductCategoryRepoEloquentInterface;
use Modules\Category\Services\ProductCategory\ProductCategoryServiceInterface;
use Modules\Discount\Repositories\AmazingSale\AmazingSaleDiscountRepoEloquentInterface;
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
        $brands = $this->productCategoryService->findProductCategoryBrands($productCategory);
        $userCartItemsProductIds = $this->cartRepo->findUserCartItems()->pluck('product_id')->all();
        return view('Category::home.products', compact(['productCategory', 'products', 'brands', 'userCartItemsProductIds']));
    }

    /**
     * @return Application|Factory|View
     */
    public function bestOffers(): View|Factory|Application
    {
        $activeAmazingSales = $this->amazingSaleRepo->bestOffers(1)->latest()->get();
        // sort items by type of them
        if (isset(request()->type)) {
            $activeAmazingSales = $this->productCategoryService->findOfferedProductsByType($activeAmazingSales, request()->type)->paginate(9);
        }   // search in items
        elseif (isset(request()->category_products_search)) {
            $products = $this->productCategoryService->findOfferedProductsByType(request()->category_products_search)->paginate(9);
        }   // filter items by brand attrs and price
        elseif (isset(request()->brands) || isset(request()->attrs) || isset(request()->price_from) || isset(request()->price_to)) {
            $products = $this->productCategoryService->findOfferedProductsByFilter(request()->brands,
                request()->attrs, request()->price_from, request()->price_to)->paginate(9);
        } else {
            $products = $this->amazingSaleRepo->bestOffers(1)->get();
        }
        // get all products brands
//        $brands = $this->productCategoryService->findOfferedProductsBrands();
        $userCartItemsProductIds = $this->cartRepo->findUserCartItems()->pluck('product_id')->all();
        return view('Category::home.best-offers', compact(['activeAmazingSales']));
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

<?php

namespace Modules\Category\Http\Controllers\Home;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Modules\Brand\Repositories\BrandRepoEloquentInterface;
use Modules\Category\Entities\ProductCategory;
use Modules\Category\Repositories\ProductCategory\ProductCategoryRepoEloquentInterface;
use Modules\Discount\Repositories\AmazingSale\AmazingSaleDiscountRepoEloquentInterface;
use Modules\Product\Repositories\Product\ProductRepoEloquentInterface;
use Modules\Share\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public BrandRepoEloquentInterface $brandRepo;
    public ProductRepoEloquentInterface $productRepo;
    public ProductCategoryRepoEloquentInterface $productCategoryRepo;
    public AmazingSaleDiscountRepoEloquentInterface $amazingSaleRepo;

    /**
     * @param BrandRepoEloquentInterface $brandRepoEloquent
     * @param AmazingSaleDiscountRepoEloquentInterface $amazingSaleDiscountRepoEloquent
     * @param ProductRepoEloquentInterface $productRepoEloquent
     * @param ProductCategoryRepoEloquentInterface $productCategoryRepoEloquent
     */
    public function __construct(BrandRepoEloquentInterface               $brandRepoEloquent,
                                AmazingSaleDiscountRepoEloquentInterface $amazingSaleDiscountRepoEloquent,
                                ProductRepoEloquentInterface             $productRepoEloquent,
                                ProductCategoryRepoEloquentInterface     $productCategoryRepoEloquent)
    {
        $this->brandRepo = $brandRepoEloquent;
        $this->amazingSaleRepo = $amazingSaleDiscountRepoEloquent;
        $this->productRepo = $productRepoEloquent;
        $this->productCategoryRepo = $productCategoryRepoEloquent;
    }

    /**
     * @param ProductCategory $productCategory
     * @return Application|Factory|View
     */
    public function categoryProducts(ProductCategory $productCategory): Factory|View|Application
    {
//        if ($productCategory->children()) {
//            $categoryChilds = $productCategory->children()->orderBy('id', 'desc')->get();
//            return view('customer.market.product.category-products', compact('categoryChilds'));
//        }
        // برندها
        $brands = $this->brandRepo->index()->get();
        $products = $productCategory->products()->latest()->paginate(9);
        return view('Category::home.products', compact(['productCategory', 'products', 'brands']));
    }

    /**
     * @return Application|Factory|View
     */
    public function bestOffers(): View|Factory|Application
    {
        // برندها
        $brands = $this->brandRepo->index()->get();
        $productsWithActiveAmazingSales = $this->amazingSaleRepo->bestOffers()->get();
        $productCategory = $productsWithActiveAmazingSales[0]->category;
        return view('Category::home.best-offers', compact(['productsWithActiveAmazingSales', 'brands', 'productCategory']));
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

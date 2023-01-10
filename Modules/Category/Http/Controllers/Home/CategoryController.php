<?php

namespace Modules\Category\Http\Controllers\Home;

use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Modules\Brand\Entities\Brand;
use Modules\Category\Entities\ProductCategory;
use Modules\Discount\Entities\AmazingSale;
use Modules\Product\Entities\Product;
use Modules\Share\Http\Controllers\Controller;

class CategoryController extends Controller
{
    /**
     * @param ProductCategory $productCategory
     * @return Application|Factory|View
     */
    public function categoryProducts(ProductCategory $productCategory)
    {
//        if ($productCategory->children()) {
//            $categoryChilds = $productCategory->children()->orderBy('id', 'desc')->get();
//            return view('customer.market.product.category-products', compact('categoryChilds'));
//        }
        // برندها
        $brands = Brand::all();
        $products = $productCategory->products()->orderBy('id', 'desc')->get();
        return view('Category::home.products', compact('productCategory', 'products', 'brands'));
    }

    /**
     * @return Application|Factory|View
     */
    public function bestOffers()
    {
        // برندها
        $brands = Brand::all();
        $productsWithActiveAmazingSales = AmazingSale::query()->where('start_date', '<', Carbon::now())->where('end_date', '>', Carbon::now())->where('status', 1)->
        where('percentage', '>=', 1)->get();
        return view('Category::home.best-offers', compact('productsWithActiveAmazingSales', 'brands'));
    }

    /**
     * @return Application|Factory|View
     */
    public function queryProducts()
    {
        // برندها
        $brands = Brand::all();
        $queryResult = $queryTitle = null;
        if (isset(request()->inputQuery)) {
            switch (request()->inputQuery) {
                case 'productsWithActiveAmazingSales':
                    $queryTitle = 'محصولات فروش ویژه';
                    $amazingSales = AmazingSale::query()->where([
                        ['start_date', '<', Carbon::now()],
                        ['end_date', '>', Carbon::now()],
                        ['status', 1],
                        ['percentage', '>=', 1]
                    ])->get();
                    $queryResult = collect();
                    foreach ($amazingSales as $amazingSale) {
                        $queryResult->push($amazingSale->product);
                    }
                    break;
                case 'mostVisitedProducts':
                    $queryTitle = 'پربازدبدترین کالاها';
                    // پربازدید ترین کالاها
                    $queryResult = Product::query()->latest()->take(10)->get();
                    break;
                case 'offerProducts':
                    $queryTitle = 'محصولات پیشنهادی';
                    // کالاهای پیشنهادی
                    $queryResult = Product::query()->latest()->take(10)->get();
                    break;
                case 'newestProducts':
                    $queryTitle = 'جدیدترین محصولات';
                    $queryResult = Product::query()->latest()->take(10)->get();
                    break;
                default:

            }
        }
        $productCategory = count($queryResult) == 0 ?
            ProductCategory::query()->findOrFail(1) :
            $queryResult[0]->category;

        return view('Category::home.query-products', compact('queryResult', 'queryTitle',
            'brands', 'productCategory'));
    }
}

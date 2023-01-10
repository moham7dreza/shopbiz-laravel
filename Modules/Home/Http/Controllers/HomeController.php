<?php

namespace Modules\Home\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Modules\Brand\Entities\Brand;
use Modules\Category\Entities\ProductCategory;
use Modules\Home\Repositories\HomeRepoEloquent;
use Modules\Home\Repositories\HomeRepoEloquentInterface;
use Modules\Product\Entities\Product;
use Modules\Share\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function home(HomeRepoEloquentInterface $repo)
    {
        return view('Home::home', compact(['repo']));
    }

    public function liveSearch(Request $request)
    {
        if ($request->ajax()) {
            $name = $request->search;
            if (isset($name) && strlen($name) > 0) {
                $results = collect();
                $productResults = Product::query()->where('name', 'like', '%' . $name . '%')->get();
                if (count($productResults) > 0) {
                    $results->put('products', $productResults);
                }
                $productCategoryResults = ProductCategory::query()->where('name', 'like', '%' . $name . '%')->get();
                if (count($productCategoryResults) > 0) {
                    $results->put('categories', $productCategoryResults);
                }
                $brandResults = Brand::query()->where('persian_name', 'like', '%' . $name . '%')->get();
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
}

<?php

namespace Modules\Home\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Modules\Banner\Entities\Banner;
use Modules\Brand\Entities\Brand;
use Modules\Product\Entities\Product;
use Modules\Share\Http\Controllers\Controller;

class HomeController extends Controller
{


    /**
     * @return Application|Factory|View
     */
    public function home()
    {
        Auth::loginUsingId(1);

        $slideShowImages = Banner::query()->where('position', 0)->where('status', 1)->get();
        $topBanners = Banner::query()->where('position', 1)->where('status', 1)->take(2)->get();
        $middleBanners = Banner::query()->where('position', 2)->where('status', 1)->take(2)->get();
        $bottomBanner = Banner::query()->where('position', 3)->where('status', 1)->first();

        $brands = Brand::all();

        $mostVisitedProducts = Product::query()->latest()->take(10)->get();
        $offerProducts = Product::query()->latest()->take(10)->get();
        return view('Home::home', compact('slideShowImages', 'topBanners', 'middleBanners', 'bottomBanner', 'brands', 'mostVisitedProducts', 'offerProducts'));

    }


}

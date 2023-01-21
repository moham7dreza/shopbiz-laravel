<?php

namespace Modules\Home\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\ACL\Entities\Permission;
use Modules\ACL\Enums\DefineSystemPermissionsEnum;
use Modules\Brand\Entities\Brand;
use Modules\Category\Entities\ProductCategory;
use Modules\Home\Repositories\HomeRepoEloquent;
use Modules\Home\Repositories\HomeRepoEloquentInterface;
use Modules\Home\Services\HomeService;
use Modules\Product\Entities\Product;
use Modules\Share\Enums\DefaultStatusEnum;
use Modules\Share\Http\Controllers\Controller;

class HomeController extends Controller
{
    private HomeService $service;

    public function __construct(HomeService $homeService)
    {
        $this->service = $homeService;
    }

    /**
     * @param HomeRepoEloquentInterface $repo
     * @return Application|Factory|View
     */
    public function home(HomeRepoEloquentInterface $repo): Factory|View|Application
    {
        return view('Home::home', compact(['repo']));
    }


    /**
     * @param Request $request
     * @return JsonResponse|void|null
     */
    public function liveSearch(Request $request)
    {
        if ($request->ajax()) {
            return $this->service->search($request->search);
        }
    }
}

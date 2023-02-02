<?php

namespace Modules\Home\Http\Controllers;

use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Home\Repositories\HomeRepoEloquentInterface;
use Modules\Home\Services\HomeService;
use Modules\Share\Http\Controllers\Controller;
use Modules\Share\Services\ShareService;

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
        $this->setMetas($repo);

        if (session('block') !== 'yes') {
            ShareService::showGreetingToast();
        }
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

    /**
     * @param HomeRepoEloquentInterface $repo
     * @return void
     */
    private function setMetas(HomeRepoEloquentInterface $repo): void
    {
        SEOMeta::setKeywords($repo->siteSetting()->keywords);
        SEOTools::setTitle($repo->siteSetting()->title);
        SEOTools::setDescription($repo->siteSetting()->description);
        SEOTools::opengraph()->setUrl('http://current.url.com');
        SEOTools::setCanonical('https://codecasts.com.br/lesson');
        SEOTools::opengraph()->addProperty('type', 'articles');
        SEOTools::twitter()->setSite('@LuizVinicius73');
        SEOTools::jsonLd()->addImage('https://codecasts.com.br/img/logo.jpg');
        SEOMeta::addMeta('author', $repo->siteSetting()->title);
    }
}

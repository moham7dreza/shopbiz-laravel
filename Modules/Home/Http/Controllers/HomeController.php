<?php

namespace Modules\Home\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Modules\Home\Repositories\HomeRepoEloquent;
use Modules\Home\Repositories\HomeRepoEloquentInterface;
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
}

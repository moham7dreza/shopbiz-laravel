<?php

namespace Modules\Home\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Modules\Home\Repositories\HomeRepoEloquent;
use Modules\Share\Http\Controllers\Controller;

class HomeController extends Controller
{
    public HomeRepoEloquent $homeRepo;

    public function __construct(HomeRepoEloquent $homeRepoEloquent)
    {
        $this->homeRepo = $homeRepoEloquent;
    }

    /**
     * @return Application|Factory|View
     */
    public function home()
    {
        $repo = $this->homeRepo;
        return view('Home::home', compact(['repo']));
    }
}

<?php

namespace Modules\Category\Post\Http\Controllers;

use Modules\Share\Http\Controllers\Controller;

class PostCategoryController extends Controller
{

    public function index()
    {
        dd(1);
        return view('PostCategory::index');
    }
}

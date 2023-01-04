<?php

namespace Modules\Post\Http\Controllers;

use Modules\Share\Http\Controllers\Controller;

class PostController extends Controller
{
    public function index()
    {
        dd(1);
        return view('Post::index');
    }
}

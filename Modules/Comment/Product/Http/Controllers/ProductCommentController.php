<?php

namespace Modules\Comment\Product\Http\Controllers;

use Modules\Share\Http\Controllers\Controller;

class ProductCommentController extends Controller
{

    public function index()
    {
        dd(1);
        return view('ProductComment::index');
    }

    public function show($id)
    {

    }
}

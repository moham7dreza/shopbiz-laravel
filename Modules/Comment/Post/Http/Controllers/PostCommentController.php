<?php

namespace Modules\Comment\Post\Http\Controllers;

use Modules\Share\Http\Controllers\Controller;

class PostCommentController extends Controller
{
    public function index()
    {
        dd(1);
        return view('PostComment::index');
    }
}

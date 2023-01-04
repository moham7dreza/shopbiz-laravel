<?php

namespace Modules\ACL\Http\Controllers;

use Modules\Share\Http\Controllers\Controller;

class AclController extends Controller
{
    public function index()
    {
        dd(1);
        return view('ACL::index');
    }
}

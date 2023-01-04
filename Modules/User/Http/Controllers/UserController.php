<?php

namespace Modules\User\Http\Controllers;

use Modules\Share\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index()
    {
        dd(1);
        return view('User::index');
    }
}

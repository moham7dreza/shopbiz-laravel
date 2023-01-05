<?php

namespace Modules\User\Http\Controllers\Home\Profile;


use Modules\Share\Http\Controllers\Controller;
use Modules\User\Entities\Province;

class AddressController extends Controller
{
    public function index()
    {
        $provinces = Province::all();
        return view('User::home.profile.my-addresses', compact('provinces'));
    }
}

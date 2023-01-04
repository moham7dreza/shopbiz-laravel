<?php

namespace Modules\Faq\Http\Controllers;

use Modules\Share\Http\Controllers\Controller;

class FaqController extends Controller
{
    public function index()
    {
        dd(1);
        return view('Faq::index');
    }
}

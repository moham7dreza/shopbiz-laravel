<?php

namespace Modules\Category\Product\Http\Controllers;

use Modules\Share\Http\Controllers\Controller;

class ProductCategoryController extends Controller
{

    public function index()
    {
        return view('ProductCategory::index');
    }
}

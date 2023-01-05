<?php

namespace Modules\User\Http\Controllers\Home\Profile;


use Modules\Share\Http\Controllers\Controller;
use Modules\User\Http\Controllers\Home\Product;

class FavoriteController extends Controller
{
    public function index()
    {
        return view('User::home.profile.my-favorites');
    }

    public function delete(Product $product)
    {
        $user = auth()->user();
        $user->products()->detach($product->id);
        return redirect()->route('customer.profile.my-favorites')->with('success', 'محصول با موفقیت از علاقه مندی ها حذف شد');
    }
}

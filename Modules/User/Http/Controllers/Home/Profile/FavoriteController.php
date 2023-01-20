<?php

namespace Modules\User\Http\Controllers\Home\Profile;


use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Modules\Product\Entities\Product;
use Modules\Share\Http\Controllers\Controller;

class FavoriteController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function index(): View|Factory|Application
    {
        $products = auth()->user()->products()->latest()->get();
        return view('User::home.profile.my-favorites', compact(['products']));
    }

    /**
     * @param Product $product
     * @return RedirectResponse
     */
    public function delete(Product $product): RedirectResponse
    {
        auth()->user()->products()->detach($product->id);
        return to_route('customer.profile.my-favorites')
            ->with('success', 'محصول با موفقیت از علاقه مندی ها حذف شد');
    }
}

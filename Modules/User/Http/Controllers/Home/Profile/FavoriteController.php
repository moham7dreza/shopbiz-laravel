<?php

namespace Modules\User\Http\Controllers\Home\Profile;


use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Modules\Post\Entities\Post;
use Modules\Product\Entities\Product;
use Modules\Share\Http\Controllers\Controller;
use Modules\Share\Traits\ShowMessageWithRedirectTrait;

class FavoriteController extends Controller
{
    use ShowMessageWithRedirectTrait;

    /**
     * @return Application|Factory|View
     */
    public function index(): View|Factory|Application
    {
        $products = auth()->user()->products()->latest()->get();
        $posts = auth()->user()->posts()->latest()->get();
        return view('User::home.profile.my-favorites', compact(['products', 'posts']));
    }

    /**
     * @param Product $product
     * @return RedirectResponse
     */
    public function deleteProduct(Product $product): RedirectResponse
    {
        auth()->user()->products()->detach($product->id);
        return $this->showToastWithRedirect(title: 'محصول با موفقیت از علاقه مندی ها حذف شد', route: 'customer.profile.my-favorites');
//        return to_route('customer.profile.my-favorites')->with('success', 'محصول با موفقیت از علاقه مندی ها حذف شد');
    }

    /**
     * @param Post $post
     * @return RedirectResponse
     */
    public function deletePost(Post $post): RedirectResponse
    {
        auth()->user()->posts()->detach($post->id);
        return $this->showToastWithRedirect(title: 'پست با موفقیت از علاقه مندی ها حذف شد', route: 'customer.profile.my-favorites');
//        return to_route('customer.profile.my-favorites')->with('success', 'محصول با موفقیت از علاقه مندی ها حذف شد');
    }
}

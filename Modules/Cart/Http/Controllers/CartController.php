<?php

namespace Modules\Cart\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\Cart\Entities\CartItem;
use Modules\Cart\Http\Requests\CartRequest;
use Modules\Cart\Repositories\CartRepoEloquentInterface;
use Modules\Cart\Services\CartService;
use Modules\Product\Entities\Product;
use Modules\Product\Repositories\Product\ProductRepoEloquentInterface;
use Modules\Share\Http\Controllers\Controller;

class CartController extends Controller
{
    /**
     * @var string
     */
    private string $class = CartItem::class;

    public CartRepoEloquentInterface $repo;
    public CartService $service;

    /**
     * @param CartRepoEloquentInterface $cartRepoEloquent
     * @param CartService $cartService
     */
    public function __construct(CartRepoEloquentInterface $cartRepoEloquent, CartService $cartService)
    {
        $this->repo = $cartRepoEloquent;
        $this->service = $cartService;

//        $this->middleware('can:auth');

        if (!auth()->check()) {
            return to_route('auth.login-register-form');
        }
    }

    /**
     * @param ProductRepoEloquentInterface $productRepo
     * @return Application|Factory|View|RedirectResponse
     */
    public function cart(ProductRepoEloquentInterface $productRepo): View|Factory|RedirectResponse|Application
    {
        $cartItems = $this->repo->findUserCartItems()->get();
        if ($cartItems->count() > 0) {
            $relatedProducts = $productRepo->index()->get();
            return view('Cart::home.cart', compact(['cartItems', 'relatedProducts']));
        } else {
            return redirect()->back()->with('danger', 'سبد خرید شما خالی است.');
        }
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function updateCart(Request $request): RedirectResponse
    {
        $cartItems = $this->repo->findUserCartItems()->get();
        $this->service->updateCartItems($request, $cartItems);
        return redirect()->route('customer.sales-process.address-and-delivery');
    }


    /**
     * @param Product $product
     * @param CartRequest $request
     * @return RedirectResponse
     */
    public function addToCart(Product $product, CartRequest $request): RedirectResponse
    {
        $cartItems = $this->repo->findUserCartItemsWithRelatedProduct($product->id)->get();
        $this->service->store($request, $product->id, $cartItems);
        return back()->with('swal-timer', 'محصول مورد نظر با موفقیت به سبد خرید اضافه شد');
    }


    /**
     * @param CartItem $cartItem
     * @return RedirectResponse
     */
    public function removeFromCart(CartItem $cartItem): RedirectResponse
    {
        if ($cartItem->user_id === auth()->id()) {
            $cartItem->delete();
            $cartItems = $this->repo->findUserCartItems()->get();
            if ($cartItems->count() == 0) {
                return to_route('customer.home')->with('warning', 'سبد خرید شما خالی شد. میتوانید از محصولات دیگر ما دیدن فرمایید.');
            }
        }
        return back()->with('success', 'محصول مورد نظر با موفقیت از سبد خرید حذف شد');
    }
}

<?php

namespace Modules\Cart\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Cart\Entities\CartItem;
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
    }

    /**
     * @param ProductRepoEloquentInterface $productRepo
     * @return Application|Factory|View|RedirectResponse
     */
    public function cart(ProductRepoEloquentInterface $productRepo): View|Factory|RedirectResponse|Application
    {
        if (Auth::check()) {
            $cartItems = $this->repo->findUserCartItems()->get();
            if ($cartItems->count() > 0) {
                $relatedProducts = $productRepo->index()->get();
                return view('Cart::home.cart', compact(['cartItems', 'relatedProducts']));
            } else {
                return redirect()->back();
            }

        } else {
            return redirect()->route('auth.customer.login-register-form');
        }
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function updateCart(Request $request): RedirectResponse
    {
        $inputs = $request->all();
        $cartItems = $this->repo->findUserCartItems()->get();
        foreach ($cartItems as $cartItem) {
            if (isset($inputs['number'][$cartItem->id])) {
                $cartItem->update(['number' => $inputs['number'][$cartItem->id]]);
            }
        }
        return redirect()->route('customer.sales-process.address-and-delivery');
    }


    /**
     * @param Product $product
     * @param Request $request
     * @return RedirectResponse
     */
    public function addToCart(Product $product, Request $request): RedirectResponse
    {
        if (Auth::check()) {
            $request->validate([
                'color' => 'nullable|exists:product_colors,id',
                'guarantee' => 'nullable|exists:guarantees,id',
                'number' => 'numeric|min:1|max:5'
            ]);

            $cartItems = $this->repo->findUserCartItemsWithRelatedProduct($product->id)->get();

            if (!isset($request->color)) {
                $request->color = null;
            }
            if (!isset($request->guarantee)) {
                $request->guarantee = null;
            }

            foreach ($cartItems as $cartItem) {
                if ($cartItem->color_id == $request->color && $cartItem->guarantee_id == $request->guarantee) {
                    if ($cartItem->number != $request->number) {
                        $cartItem->update(['number' => $request->number]);
                    }
                    return back();
                }
            }

            $inputs = [];
            $inputs['color_id'] = $request->color;
            $inputs['guarantee_id'] = $request->guarantee;
            $inputs['user_id'] = auth()->user()->id;
            $inputs['product_id'] = $product->id;

            CartItem::query()->create($inputs);

            return back()->with('alert-section-success', 'محصول مورد نظر با موفقیت به سبد خرید اضافه شد');

        } else {
            return redirect()->route('auth.customer.login-register-form');
        }
    }


    /**
     * @param CartItem $cartItem
     * @return RedirectResponse
     */
    public function removeFromCart(CartItem $cartItem): RedirectResponse
    {
        if ($cartItem->user_id === Auth::user()->id) {
            $cartItem->delete();
        }
        return back();
    }
}

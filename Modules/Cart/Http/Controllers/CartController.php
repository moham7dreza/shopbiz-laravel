<?php

namespace Modules\Cart\Http\Controllers;

use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\SEOTools;
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
use Modules\Product\Repositories\ProductColor\ProductColorRepoEloquentInterface;
use Modules\Product\Repositories\Product\ProductRepoEloquentInterface;
use Modules\Share\Http\Controllers\Controller;
use Modules\Share\Traits\ShowMessageWithRedirectTrait;

class CartController extends Controller
{
    use ShowMessageWithRedirectTrait;

    /**
     * @var string
     */
    private string $class = CartItem::class;

    public CartRepoEloquentInterface $repo;
    public CartService $service;
    public ProductColorRepoEloquentInterface $productColorRepo;

    /**
     * @param CartRepoEloquentInterface $cartRepoEloquent
     * @param CartService $cartService
     * @param ProductColorRepoEloquentInterface $productColorRepo
     */
    public function __construct(CartRepoEloquentInterface $cartRepoEloquent, CartService $cartService, ProductColorRepoEloquentInterface $productColorRepo)
    {
        $this->repo = $cartRepoEloquent;
        $this->service = $cartService;
        $this->productColorRepo = $productColorRepo;
    }

    /**
     * @param ProductRepoEloquentInterface $productRepo
     * @return Application|Factory|View|RedirectResponse
     */
    public function cart(ProductRepoEloquentInterface $productRepo): View|Factory|RedirectResponse|Application
    {
        SEOTools::setTitle('سبد خرید شما');
        SEOTools::setDescription('سبد خرید شما');
        SEOMeta::setKeywords('سبد خرید شما');

        $cartItems = $this->repo->findUserCartItems()->with('product')->get();
        if ($cartItems->count() > 0) {
            $relatedProducts = $productRepo->findRelatedProducts($cartItems->pluck('product'));
            return view('Cart::home.cart', compact(['cartItems', 'relatedProducts']));
        } else {
            return $this->showToastWithRedirect('سبد خرید شما خالی است.', type: 'warning');
//            return redirect()->back()->with('danger', 'سبد خرید شما خالی است.');
        }
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function updateCart(Request $request): RedirectResponse
    {
        $cartItems = $this->repo->findUserCartItems()->get();
        $result = $this->service->updateCartItems($request, $cartItems);
        if ($result != 'updated') {
            return $this->showAlertWithRedirect('موجودی کالاها هم اکنون کافی نمی باشد.', title: 'هشدار', type: 'warning')->with('products', $result);
        }
        return $this->showToastWithRedirect('کالاهای انتخاب شده برای شما ثبت شد.', route: 'customer.sales-process.address-and-delivery');
    }


    /**
     * @param Product $product
     * @param CartRequest $request
     * @return RedirectResponse
     */
    public function addToCart(Product $product, CartRequest $request): RedirectResponse
    {
        $cartItems = $this->repo->findUserCartItemsWithRelatedProduct($product->id)->get();
        $result = $this->service->store($request, $product->id, $cartItems);
        if ($result == 'requested number can not provided') {
            return $this->showAlertWithRedirect('موجودی کالا هم اکنون ' . convertEnglishToPersian($product->marketable_number) . ' عدد است.',
                title: 'هشدار', type: 'warning', timer: 10000);
        } elseif ($result == 'requested number on this color can not provided') {
            $productSelectedColor = $this->productColorRepo->findById($request->color);
            return $this->showAlertWithRedirect('موجودی کالا هم اکنون برای رنگ ' . $productSelectedColor->color_name . ' فقط ' . convertEnglishToPersian($productSelectedColor->marketable_number) . ' عدد است.',
                title: 'هشدار', type: 'warning', timer: 10000);
        } elseif ($result == 'requested color is invalid') {
            return $this->showAlertWithRedirect('رنگ انتخاب شده معتبر نمی باشد.', title: 'هشدار', type: 'warning', timer: 10000);
        }
        elseif ($result == 'product already in cart') {
//            return $this->showAlertWithRedirect('محصول قبلا به سبد خرید اضافه شده است.', 'هشدار', 'animated with footer', 'warning');
            return $this->showToastWithRedirect('محصول قبلا به سبد خرید اضافه شده است.', type: 'error');
        } else if ($result == 'product updated') {
            return $this->showToastWithRedirect('محصول مورد نظر با موفقیت بروزرسانی شد', type: 'info');
        } else {
            return $this->showToastWithRedirect('محصول مورد نظر با موفقیت به سبد خرید اضافه شد');
        }
//        return back()->with('swal-timer', 'محصول مورد نظر با موفقیت به سبد خرید اضافه شد');
    }


    /**
     * @param CartItem $cartItem
     * @return RedirectResponse
     */
    public function removeFromCart(CartItem $cartItem): RedirectResponse
    {
        if ($cartItem->user_id === auth()->id()) {
            $this->service->decreaseFrozenNumberAndDelete($cartItem);
            $cartItems = $this->repo->findUserCartItems()->get();
            if ($cartItems->count() == 0) {
                return $this->showToastWithRedirect(title: 'سبد خرید شما خالی شد. میتوانید از محصولات دیگر ما دیدن فرمایید.',
                    type: 'warning', route: 'customer.home');
//                return to_route('customer.home');->with('warning', 'سبد خرید شما خالی شد. میتوانید از محصولات دیگر ما دیدن فرمایید.');
            }
        }
        return $this->showToastWithRedirect('محصول مورد نظر با موفقیت از سبد خرید حذف شد');
//        return back()->with('success', 'محصول مورد نظر با موفقیت از سبد خرید حذف شد');
    }

    /**
     * @return RedirectResponse
     */
    public function removeAllFromCart(): RedirectResponse
    {
        $cartItems = $this->repo->findUserCartItems()->get();
        if ($cartItems->count() == 0) {
            return $this->showToastWithRedirect(title: 'سبد خرید شما خالی شد. میتوانید از محصولات دیگر ما دیدن فرمایید.', type: 'warning', route: 'customer.home');
//                    ->with('warning', 'سبد خرید شما خالی شد. میتوانید از محصولات دیگر ما دیدن فرمایید.');
        }
        foreach ($cartItems as $cartItem) {
            $this->removeFromCart($cartItem);
        }
        return $this->showAlertWithRedirect('همه محصولات شما از سبد خرید حذف شدند.');
    }
}

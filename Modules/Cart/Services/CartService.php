<?php

namespace Modules\Cart\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Modules\Cart\Entities\CartItem;
use Modules\Cart\Repositories\CartRepoEloquentInterface;
use Modules\Product\Repositories\Color\ProductColorRepoEloquentInterface;
use Modules\Product\Repositories\Product\ProductRepoEloquent;
use Modules\Product\Repositories\Product\ProductRepoEloquentInterface;

class CartService implements CartServiceInterface
{
    public ProductRepoEloquentInterface $productRepo;
    public CartRepoEloquentInterface $cartRepo;
    public ProductColorRepoEloquentInterface $productColorRepo;

    /**
     * @param ProductRepoEloquentInterface $productRepo
     * @param CartRepoEloquentInterface $cartRepo
     * @param ProductColorRepoEloquentInterface $productColorRepo
     */
    public function __construct(ProductRepoEloquentInterface $productRepo, CartRepoEloquentInterface $cartRepo, ProductColorRepoEloquentInterface $productColorRepo)
    {
        $this->productRepo = $productRepo;
        $this->cartRepo = $cartRepo;
        $this->productColorRepo = $productColorRepo;
    }

    /**
     * update cart items number before go to address and delivery selection
     *
     * @param $request
     * @param $cartItems
     * @return Collection|string
     */
    public function updateCartItems($request, $cartItems): Collection|string
    {
        // check products can not be provided with that number
        $lowCountProducts = collect();
        foreach ($cartItems as $cartItem) {
            if (isset($request->number[$cartItem->id])) {
                $newNumber = $request->number[$cartItem->id];
                // find product and color
                $product = $this->productRepo->findById($cartItem->product_id);
                // check for color selected and update count
                if (!is_null($cartItem->color_id)) {
                    $productSelectedColor = $this->productColorRepo->findById($cartItem->color_id);
                    if ($newNumber > $product->marketable_number && $newNumber > $productSelectedColor->marketable_number) {
                        $lowCountProducts->push($product);
                    }
                    $productSelectedColor->frozen_number += ($newNumber - $cartItem->number);
                    $productSelectedColor->save();
                    $product->frozen_number += ($newNumber - $cartItem->number);
                    $product->save();
                }   // color is not selected
                else {
                    // not provided
                    if ($newNumber > $product->marketable_number) {
                        $lowCountProducts->push($product);
                    } // can provided
                    else {
                        $product->frozen_number += ($newNumber - $cartItem->number);
                        $product->save();
                    }
                }
                $cartItem->update(['number' => $newNumber]);
            }
        }
        if ($lowCountProducts->count() > 0) {
            return $lowCountProducts;
        }
        return 'updated';
    }

    /**
     * @param $request
     * @param $productId
     * @param $cartItems
     * @return Builder|Model|string
     */
    public function store($request, $productId, $cartItems): Model|Builder|string
    {
        $product = $this->productRepo->findById($productId);

        if (!isset($request->color)) {
            $request->color = null;
        }
        if (!isset($request->guarantee)) {
            $request->guarantee = null;
        }
        // check if same options not selected for current product
        foreach ($cartItems as $cartItem) {
            if ($cartItem->color_id == $request->color && $cartItem->guarantee_id == $request->guarantee) {
                if ($cartItem->number != $request->number) {
                    if (!is_null($request->color)) {
                        // check product selected color has marketable
                        $productSelectedColor = $this->productColorRepo->findById($request->color);
                        if ($request->number > $productSelectedColor->marketable_number) {
                            return 'requested number on this color can not provided';
                        }
                        // calc new numbers for color and product
                        $productSelectedColor->frozen_number += ($request->number - $cartItem->number);
                        $productSelectedColor->save();
                        //
                    }
                    $product->frozen_number += ($request->number - $cartItem->number);
                    $product->save();
                    $cartItem->update(['number' => $request->number]);
                    return 'product updated';
//                    return redirect()->back()->with('info', 'محصول مورد نظر با موفقیت بروزرسانی شد');
                } else {
                    return 'product already in cart';
//                    return to_route('customer.sales-process.cart');
//                    return ShareService::animateAlert('محصول قبلا به سبد خرید اضافه شده است.');
//                    return back()->with('swal-animate', "محصول قبلا به سبد خرید اضافه شده است. برای ویرایش وارد سبد خرید خود شوید.");
                }
            }
        }
        // update product marketable and frozen numbers
        if ($request->number > $product->marketable_number) {
            return 'requested number can not provided';
        }
        // product color check
        if ($product->colors->count() > 0) {
            if ($product->colors()->pluck('id')->contains($request->color)) {
                $productSelectedColor = $this->productColorRepo->findById($request->color);
                if ($request->number > $productSelectedColor->marketable_number) {
                    return 'requested number on this color can not provided';
                }
                $productSelectedColor->frozen_number += $request->number;
                $productSelectedColor->save();
            } else {
                return 'requested color is invalid';
            }
        }
        $product->frozen_number += $request->number;
//        $product->marketable_number -= $request->number;
        $product->save();
        //

        return $this->query()->create([
            'color_id' => $request->color,
            'number' => $request->number,
            'product_id' => $productId,
            'user_id' => auth()->id(),
            'guarantee_id' => $request->guarantee,
        ]);
    }

    /**
     * @param $cartItem
     * @return void
     */
    public function decreaseFrozenNumberAndDelete($cartItem): void
    {
        // decrease count for product
        $product = $this->productRepo->findById($cartItem->product_id);
        $product->frozen_number -= $cartItem->number;
        $product->save();
        // for selected color
        if (!is_null($cartItem->color_id)) {
            $productSelectedColor = $this->productColorRepo->findById($cartItem->color_id);
            $productSelectedColor->frozen_number -= $cartItem->number;
            $productSelectedColor->save();
        }
        $cartItem->delete();
    }

    /**
     * @param $cartItems
     * @return Collection|string
     */
    public function checkCartItemsAvailabilityAndDeleteNotAvailableCartItems($cartItems): string|Collection
    {
        // check for another user buy products before than current user
        $lowCountProducts = collect();
        foreach ($cartItems as $cartItem) {
            $product = $this->productRepo->findById($cartItem->product_id);
            if ($product->marketable_number < $cartItem->number) {
                $lowCountProducts->push($product);
                $this->decreaseFrozenNumberAndDelete($cartItem);
            }
        }
        if ($lowCountProducts->count() > 0) {
            return $lowCountProducts;
        }
        return 'available';
    }

    /**
     * @return Builder
     */
    public function query(): Builder
    {
        return CartItem::query();
    }
//    /**
//     * Add product into cart in session by product id.
//     *
//     * @param  $productId
//     * @return void
//     * @throws \Psr\Container\ContainerExceptionInterface
//     * @throws \Psr\Container\NotFoundExceptionInterface
//     */
//    public function add($productId)
//    {
//        $product = resolve(ProductRepoEloquent::class)->findById($productId)->load('first_media');
//        $cart = $this->checkCart($productId, session()->get('cart'), $product);
//
//        session()->put('cart', $cart);
//    }
//
//    /**
//     * Remove product from session by product id.
//     *
//     * @param  $productId
//     * @return void
//     * @throws \Psr\Container\ContainerExceptionInterface
//     * @throws \Psr\Container\NotFoundExceptionInterface
//     */
//    public function remove($productId)
//    {
//        $cart = session()->get('cart');
//
//        if (isset($cart[$productId])) {
//            if ($cart[$productId]['quantity'] > 1) {
//                $cart[$productId]['quantity'] -= 1;
//            } else {
//                unset($cart[$productId]);
//            }
//
//            session()->put('cart', $cart);
//        }
//    }
//
//    /**
//     * Remove cart session.
//     *
//     * @return void
//     */
//    public function removeAll()
//    {
//        session()->forget('cart');
//    }
//
//    /**
//     * Check item in cart by id.
//     *
//     * @param  $id
//     * @return bool
//     */
//    public function check($id)
//    {
//        return session()->has("cart.$id");
//    }
//
//    # Static methods
//
//    /**
//     * Handle total price.
//     *
//     * @return  float|int
//     * @throws \Psr\Container\ContainerExceptionInterface
//     * @throws \Psr\Container\NotFoundExceptionInterface
//     */
//    public static function handleTotalPrice()
//    {
//        $total = 0;
//
//        if (! is_null(session()->get('cart'))) {
//            foreach (session()->get('cart') as $item) {
//                $total += $item['price'] * $item['quantity'];
//            }
//        }
//
//        return $total;
//    }
//
//    /**
//     * Handle one product price.
//     *
//     * @param  $productId
//     * @return float|int
//     * @throws \Psr\Container\ContainerExceptionInterface
//     * @throws \Psr\Container\NotFoundExceptionInterface
//     */
//    public static function handleTotalOneItemPrice($productId)
//    {
//        $product = (object) session()->get('cart')[$productId];
//
//        if (is_null($product)) {
//            return 0;
//        }
//
//        return $product->price * $product->quantity;
//    }
//
//    # Private methods
//
//    /**
//     * Check & store item.
//     *
//     * @param  $productId
//     * @param  mixed $cart
//     * @param  $product
//     * @return mixed
//     */
//    private function checkCart($productId, mixed $cart, $product): mixed
//    {
//        if ($this->check($productId)) {
//            $cart[$productId]['quantity']++;
//        } else {
//            $firstMedia = optional($product->first_media)->thumb;
//            $product = $product->toArray();
//            $product['quantity'] = 1;
//            $product['first-media'] = $firstMedia;
//            $cart[$productId] = $product;
//        }
//
//        return $cart;
//    }
}

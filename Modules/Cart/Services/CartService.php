<?php

namespace Modules\Cart\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Modules\Cart\Entities\CartItem;

class CartService implements CartServiceInterface
{

    /**
     * update cart items number before go to address and delivery selection
     *
     * @param $request
     * @param $cartItems
     * @return void
     */
    public function updateCartItems($request, $cartItems): void
    {
        foreach ($cartItems as $cartItem) {
            if (isset($request->number[$cartItem->id])) {
                $cartItem->update([
                    'number' => $request->number[$cartItem->id]
                ]);
            }
        }
    }

    /**
     * @param $request
     * @param $productId
     * @param $cartItems
     * @return Builder|Model|RedirectResponse
     */
    public function store($request, $productId, $cartItems): Model|Builder|RedirectResponse
    {
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
                    $cartItem->update(['number' => $request->number]);
                }
                return back()->with('error', "محصول قبلا به سبد خرید اضافه شده است. برای ویرایش وارد سبد خرید خود شوید.");
            }
        }

        return $this->query()->create([
            'color_id' => $request->color,
            'number' => $request->number,
            'product_id' => $productId,
            'user_id' => auth()->id(),
            'guarantee_id' => $request->guarantee,
        ]);
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

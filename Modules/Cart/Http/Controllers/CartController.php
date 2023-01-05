<?php

namespace Modules\Cart\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Cart\Entities\CartItem;
use Modules\Product\Entities\Product;
use Modules\Share\Http\Controllers\Controller;

class CartController extends Controller
{
    public function cart()
    {
        if(Auth::check())
        {
            $cartItems = CartItem::query()->where('user_id', Auth::user()->id)->get();
            if($cartItems->count() > 0)
            {
                $relatedProducts = Product::all();
                return view('customer.sales-process.cart', compact('cartItems', 'relatedProducts'));
            }
            else{
                return redirect()->back();
            }

        }
        else{
            return redirect()->route('auth.customer.login-register-form');
        }
    }

    public function updateCart(Request $request)
    {
        $inputs = $request->all();
        $cartItems = CartItem::query()->where('user_id', Auth::user()->id)->get();
        foreach($cartItems as $cartItem){
            if(isset($inputs['number'][$cartItem->id]))
            {
                $cartItem->update(['number' => $inputs['number'][$cartItem->id]]);
            }
        }
        return redirect()->route('customer.sales-process.address-and-delivery');
    }


    public function addToCart(Product $product, Request $request)
    {
        if(Auth::check())
        {
            $request->validate([
                'color' => 'nullable|exists:product_colors,id',
                'guarantee' => 'nullable|exists:guarantees,id',
                'number' => 'numeric|min:1|max:5'
            ]);

            $cartItems = CartItem::query()->where('product_id', $product->id)->where('user_id', auth()->user()->id)->get();

            if(!isset($request->color))
            {
                $request->color = null;
            }
            if(!isset($request->guarantee))
            {
                $request->guarantee = null;
            }

                foreach($cartItems as $cartItem)
                {
                    if($cartItem->color_id == $request->color && $cartItem->guarantee_id == $request->guarantee)
                    {
                        if($cartItem->number != $request->number)
                        {
                            $cartItem->update(['number' => $request->number]);
                        }
                        return back();
                    }
                }

                $inputs = [];
                $inputs['color_id'] = $request->color;
                $inputs['guarantee_id'] = $request->guarantee;
                $inputs['user_id'] =  auth()->user()->id;
                $inputs['product_id'] =  $product->id;

                CartItem::query()->create($inputs);

                return back()->with('alert-section-success', 'محصول مورد نظر با موفقیت به سبد خرید اضافه شد');

        }
        else{
            return redirect()->route('auth.customer.login-register-form');
        }
    }


    public function removeFromCart(CartItem $cartItem)
    {
       if($cartItem->user_id === Auth::user()->id)
       {
        $cartItem->delete();
       }
       return back();
    }
}

<?php

namespace Modules\Cart\Traits;

trait PriceCalcTrait
{
//productPrice + colorPrice + guaranteePrice
    /**
     * @return int
     */
    public function cartItemProductPrice(): int
    {
        $guaranteePriceIncrease = empty($this->guarantee_id) ? 0 : $this->guarantee->price_increase;
        $colorPriceIncrease = empty($this->color_id) ? 0 : $this->color->price_increase;
        return $this->product->price + $guaranteePriceIncrease + $colorPriceIncrease;
    }


    // productPrice * (discountPercentage / 100)

    /**
     * @return float|int
     */
    public function cartItemProductDiscount(): float|int
    {
        $cartItemProductPrice = $this->cartItemProductPrice();
        return empty($this->product->activeAmazingSales()) ? 0 : $cartItemProductPrice * ($this->product->activeAmazingSales()->percentage / 100);
    }


    //number * (productPrice + colorPrice + guranateePrice - discountPrice)

    /**
     * @return float|int
     */
    public function cartItemFinalPrice(): float|int
    {
        $cartItemProductPrice = $this->cartItemProductPrice();
        $productDiscount = $this->cartItemProductDiscount();
        return $this->number * ($cartItemProductPrice - $productDiscount);
    }


    //number * productDiscount

    /**
     * @return float|int
     */
    public function cartItemFinalDiscount(): float|int
    {
        $productDiscount = $this->cartItemProductDiscount();
        return $this->number * $productDiscount;
    }
}

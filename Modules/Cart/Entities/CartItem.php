<?php

namespace Modules\Cart\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Product\Entities\Guarantee;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\ProductColor;
use Modules\User\Entities\User;


class CartItem extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * @var string[]
     */
    protected $fillable = ['color_id', 'number', 'product_id', 'user_id', 'guarantee_id'];


    // Relations

    /**
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }


    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    /**
     * @return BelongsTo
     */
    public function guarantee(): BelongsTo
    {
        return $this->belongsTo(Guarantee::class);
    }


    public function color(): BelongsTo
    {
        return $this->belongsTo(ProductColor::class);
    }


    // Methods

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


    /**
     * @return string
     */
    public function productImage(): string
    {
        return asset($this->product->image['indexArray']['medium']);
    }

    /**
     * @return string
     */
    public function productName(): string
    {
        return $this->product->name ?? '-';
    }

    /**
     * @return string
     */
    public function colorName(): string
    {
        return $this->color->color_name ?? '-';
    }

    /**
     * @return string
     */
    public function guaranteeName(): string
    {
        return $this->guarantee->name ?? '-';
    }

    /**
     * @return int|string
     */
    public function productDiscount(): int|string
    {
        return priceFormat($this->cartItemProductDiscount()) . ' تومان ' ?? 0;
    }

    /**
     * @return bool|string
     */
    public function hasActiveAmazingSale(): bool|string
    {
        return !empty($this->product->activeAmazingSales()) ?? false;
    }

    /**
     * @return int|string
     */
    public function faProductPrice(): int|string
    {
        return priceFormat($this->cartItemProductPrice()) . ' تومان ' ?? 0;
    }

    /**
     * @param $price
     * @return int|string
     */
    public function faPrice($price): int|string
    {
        return priceFormat($price) . ' تومان ' ?? 0;
    }

    /**
     * @return array|int|string|string[]
     */
    public function faItemsCount(): array|int|string
    {
        return convertEnglishToPersian($this->count()) ?? 0;
    }
}

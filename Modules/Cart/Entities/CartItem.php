<?php

namespace Modules\Cart\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Cart\Traits\PriceCalcTrait;
use Modules\Product\Entities\Guarantee;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\ProductColor;
use Modules\Share\Traits\HasFaPropertiesTrait;
use Modules\Share\Traits\HasImageTrait;
use Modules\User\Entities\User;


class CartItem extends Model
{
    use HasFactory, SoftDeletes, HasImageTrait, HasFaPropertiesTrait, PriceCalcTrait;

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

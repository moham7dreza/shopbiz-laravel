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
    use HasFactory, SoftDeletes, PriceCalcTrait;

    /**
     * @var string[]
     */
    protected $fillable = ['color_id', 'number', 'product_id', 'user_id', 'guarantee_id'];


    // ********************************************* Relations

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


    // ********************************************* Methods

    /**
     * @return string
     */
    public function getProductName(): string
    {
        return $this->product->name ?? '-';
    }

    /**
     * @return string
     */
    public function getColorName(): string
    {
        return $this->color->color_name ?? '-';
    }

    /**
     * @return string
     */
    public function getGuaranteeName(): string
    {
        return $this->guarantee->name ?? '-';
    }

    /**
     * @return bool|string
     */
    public function hasActiveAmazingSale(): bool|string
    {
        return !empty($this->product->activeAmazingSales()) ?? false;
    }

    // ********************************************* paths

    /**
     * @param string $size
     * @return string
     */
    public function getProductImagePath(string $size = 'medium'): string
    {
        return asset($this->product->image['indexArray'][$size]);
    }

    // ********************************************* FA Properties

    /**
     * @return int|string
     */
    public function getFaProductDiscount(): int|string
    {
        return priceFormat($this->cartItemProductDiscount()) . ' تومان ' ?? 0;
    }

    /**
     * @return int|string
     */
    public function getFaProductPrice(): int|string
    {
        return priceFormat($this->cartItemProductPrice()) . ' تومان ' ?? 0;
    }

    /**
     * @param $price
     * @return int|string
     */
    public function getFaPrice($price): int|string
    {
        return priceFormat($price) . ' تومان ' ?? 0;
    }

    // ********************************************* FA counters

    /**
     * @return array|int|string|string[]
     */
    public function getFaItemsCount(): array|int|string
    {
        return convertEnglishToPersian($this->count()) ?? 0;
    }
}

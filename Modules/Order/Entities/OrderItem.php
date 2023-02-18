<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Discount\Entities\AmazingSale;
use Modules\Product\Entities\Guarantee;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\Color;
use Modules\Share\Traits\HasFaDate;


class OrderItem extends Model
{
    use HasFactory, SoftDeletes, HasFaDate;

    protected $fillable = ['order_id', 'product_id', 'product', 'amazing_sale_id', 'amazing_sale_object',
        'amazing_sale_discount_amount', 'number', 'final_product_price', 'final_total_price', 'color_id', 'guarantee_id'];

    // ********************************************* Relations

    /**
     * @return BelongsTo
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * @return BelongsTo
     */
    public function singleProduct(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    /**
     * @return BelongsTo
     */
    public function amazingSale(): BelongsTo
    {
        return $this->belongsTo(AmazingSale::class);
    }

    /**
     * @return BelongsTo
     */
    public function color(): BelongsTo
    {
        return $this->belongsTo(Color::class);
    }

    /**
     * @return BelongsTo
     */
    public function guarantee(): BelongsTo
    {
        return $this->belongsTo(Guarantee::class);
    }

    /**
     * @return HasMany
     */
    public function orderItemAttributes(): HasMany
    {
        return $this->hasMany(OrderItemSelectedAttribute::class);
    }

    // ********************************************* Methods

    /**
     * @return string
     */
    public function getProductName(): string
    {
        return $this->singleProduct->name ?? 'نام کالا یافت نشد.';
    }

    /**
     * @return int|string
     */
    public function getOrderItemColorName(): int|string
    {
        return $this->color->color_name ?? 'رنگ ندارد.';
    }

    /**
     * @return int|string
     */
    public function getOrderItemGuaranteeName(): int|string
    {
        return $this->guarantee->name ?? 'گارانتی ندارد.';
    }

    // ********************************************* paths


    // ********************************************* FA Properties

    /**
     * @return array|int|string
     */
    public function getFaAmazingSalePercentage(): array|int|string
    {
        return convertEnglishToPersian($this->amazingSale->percentage) . ' % ' ?? 0;
    }

    /**
     * @return int|string
     */
    public function getFaOrderItemAmazingSaleDiscountAmountPrice(): int|string
    {
        return priceFormat($this->amazing_sale_discount_amount) . ' تومان' ?? 0;
    }

    /**
     * @return array|int|string
     */
    public function orderItemFaNumber(): array|int|string
    {
        return convertEnglishToPersian($this->number) . ' عدد' ?? 0;
    }

    /**
     * @return int|string
     */
    public function getFaOrderItemFinalProductPrice(): int|string
    {
        return priceFormat($this->final_product_price) . ' تومان' ?? 0;
    }

    /**
     * @return int|string
     */
    public function getFaOrderItemFinalTotalPrice(): int|string
    {
        return priceFormat($this->final_total_price) . ' تومان' ?? 0;
    }
}

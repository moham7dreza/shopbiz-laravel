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
use Modules\Product\Entities\ProductColor;
use Modules\Share\Traits\HasFaDate;
use Modules\Share\Traits\HasFaPropertiesTrait;

class OrderItem extends Model
{
    use HasFactory, SoftDeletes, HasFaDate, HasFaPropertiesTrait;

    protected $fillable = ['order_id', 'product_id', 'product', 'amazing_sale_id', 'amazing_sale_object',
        'amazing_sale_discount_amount', 'number', 'final_product_price', 'final_total_price', 'color_id', 'guarantee_id'];

    // Relations

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
        return $this->belongsTo(ProductColor::class);
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

    // Methods

    /**
     * @return string
     */
    public function textProductName(): string
    {
        return $this->singleProduct->name ?? 'نام کالا یافت نشد.';
    }
}

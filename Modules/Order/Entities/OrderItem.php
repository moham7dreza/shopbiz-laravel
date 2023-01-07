<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Discount\Entities\AmazingSale;
use Modules\Product\Entities\Guarantee;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\ProductColor;

class OrderItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function singleProduct(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function amazingSale(): BelongsTo
    {
        return $this->belongsTo(AmazingSale::class);
    }

    public function color(): BelongsTo
    {
        return $this->belongsTo(ProductColor::class);
    }

    public function guarantee(): BelongsTo
    {
        return $this->belongsTo(Guarantee::class);
    }

    public function orderItemAttributes(): HasMany
    {
        return $this->hasMany(OrderItemSelectedAttribute::class);
    }
}

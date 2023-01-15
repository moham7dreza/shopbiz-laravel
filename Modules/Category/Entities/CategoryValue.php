<?php

namespace Modules\Category\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Product\Entities\Product;

class CategoryValue extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * @var string[]
     */
    protected $fillable = ['product_id', 'category_attribute_id', 'value', 'type'];


    // Relations

    /**
     * @return BelongsTo
     */
    public function attribute(): BelongsTo
    {
        return $this->belongsTo(CategoryAttribute::class, 'category_attribute_id');
    }

    /**
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    // Methods

    /**
     * @return string
     */
    public function getFaPrice(): string
    {
        return priceFormat(json_decode($this->value)->price_increase) . ' تومان ' ?? 0;
    }

    /**
     * @return mixed
     */
    public function getValue(): mixed
    {
        return json_decode($this->value)->value ?? '';
    }

    /**
     * @return string
     */
    public function getTextType(): string
    {
        return $this->type == 0 ? 'ساده' : 'انتخابی';
    }

    /**
     * @return string
     */
    public function textProductName(): string
    {
        return $this->product->name ?? 'نام محصول یافت نشد.';
    }
}

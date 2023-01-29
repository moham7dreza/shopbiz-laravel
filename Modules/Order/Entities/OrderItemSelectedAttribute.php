<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Attribute\Entities\Attribute;
use Modules\Attribute\Entities\AttributeValue;
use Modules\Share\Traits\HasFaDate;

class OrderItemSelectedAttribute extends Model
{
    use HasFactory, SoftDeletes, HasFaDate;

    public $fillable = ['order_item_id', 'category_attribute_id', 'category_value_id', 'value'];

    // Relations

    /**
     * @return BelongsTo
     */
    public function categoryAttribute(): BelongsTo
    {
        return $this->belongsTo(Attribute::class);
    }

    /**
     * @return BelongsTo
     */
    public function categoryAttributeValue(): BelongsTo
    {
        return $this->belongsTo(AttributeValue::class, 'category_value_id');
    }

    /**
     * @return string
     */
    public function textAttributeName(): string
    {
        return $this->categoryAttribute->name ?? 'فرم کالا ندارد.';
    }

    /**
     * @return string
     */
    public function attributeValue(): string
    {
        return $this->categoryAttributeValue->value ?? 'مقداری برای فرم کالا یافت نشد.';
    }
}

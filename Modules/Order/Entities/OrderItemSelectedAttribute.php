<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Attribute\Entities\Attribute;
use Modules\Attribute\Entities\AttributeValue;
use Modules\Share\Traits\HasFaDate;
use Modules\Share\Traits\HasFaPropertiesTrait;

class OrderItemSelectedAttribute extends Model
{
    use HasFactory, SoftDeletes, HasFaDate;

    public $fillable = ['order_item_id', 'attribute_id', 'attribute_value_id', 'value'];

    // ********************************************* Relations

    /**
     * @return BelongsTo
     */
    public function attribute(): BelongsTo
    {
        return $this->belongsTo(Attribute::class);
    }

    /**
     * @return BelongsTo
     */
    public function attributeValue(): BelongsTo
    {
        return $this->belongsTo(AttributeValue::class, 'attribute_value_id');
    }

    // ********************************************* Methods

    /**
     * @return string
     */
    public function getAttributeName(): string
    {
        return $this->attribute->name ?? 'فرم کالا ندارد.';
    }

    /**
     * @return string
     */
    public function getAttributeUnit(): string
    {
        return $this->attribute->unit ?? 'واحد اندازه گیری ندارد.';
    }

    /**
     * @return string
     */
    public function getAttributeValueAmount(): string
    {
        return convertEnglishToPersian(json_decode($this->attributeValue->value)->value) ?? 'مقداری برای فرم کالا یافت نشد.';
    }

    /**
     * @return string
     */
    public function generateAttributeDescription(): string
    {
        return $this->getAttributeName() . ' : ' . $this->getAttributeValueAmount() . ' ' . $this->getAttributeUnit();
    }
}

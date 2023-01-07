<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Category\Entities\CategoryAttribute;
use Modules\Category\Entities\CategoryValue;

class OrderItemSelectedAttribute extends Model
{
    use HasFactory;

    public function categoryAttribute(): BelongsTo
    {
        return $this->belongsTo(CategoryAttribute::class);
    }

    public function categoryAttributeValue(): BelongsTo
    {
        return $this->belongsTo(CategoryValue::class, 'category_value_id');
    }
}

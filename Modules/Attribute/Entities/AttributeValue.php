<?php

namespace Modules\Attribute\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Category\Entities\ProductCategory;
use Modules\Product\Entities\Product;
use Modules\Share\Traits\HasFaPropertiesTrait;

class AttributeValue extends Model
{
    use HasFactory, SoftDeletes, HasFaPropertiesTrait;

    public const TYPE_SIMPLE = 0;
    public const TYPE_MULTIPLE = 1;

    /**
     * @var string[]
     */
    protected $fillable = ['product_id', 'attribute_id', 'category_id', 'value', 'type'];

    /**
     * @var string
     */
    protected $table = 'attribute_values';

    // Relations

    /**
     * @return BelongsTo
     */
    public function attribute(): BelongsTo
    {
        return $this->belongsTo(Attribute::class, 'attribute_id');
    }

    /**
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
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
        return $this->type == self::TYPE_SIMPLE ? 'ساده' : 'انتخابی';
    }
}

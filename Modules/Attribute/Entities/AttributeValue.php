<?php

namespace Modules\Attribute\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Attribute\Traits\AttributeValueRoutesTrait;
use Modules\Attribute\Traits\HasTypesTrait;
use Modules\Category\Entities\ProductCategory;
use Modules\Product\Entities\Product;


class AttributeValue extends Model
{
    use HasFactory, SoftDeletes, HasTypesTrait;

    public const SELECTED = 1;
    public const NOT_SELECTED = 0;

    /**
     * @var string[]
     */
    protected $fillable = ['product_id', 'attribute_id', 'category_id', 'value', 'type', 'selected'];

    /**
     * @var string
     */
    protected $table = 'attribute_values';

    // ********************************************* scopes

    /**
     * @param $query
     * @param int $selected
     * @return mixed
     */
    public function scopeSelected($query, int $selected = self::SELECTED): mixed
    {
        return $query->where('selected', $selected);
    }

    // ********************************************* Relations

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

    // ********************************************* Methods

    /**
     * @return string
     */
    public function getProductName(): string
    {
        return $this->product->name ?? 'نام محصول یافت نشد.';
    }

    /**
     * @return string
     */
    public function getCategoryName(): string
    {
        return $this->product->category->name ?? 'دسته ندارد';
    }

    /**
     * @return string
     */
    public function getAttributeName(): string
    {
        return $this->attribute->name ?? 'فرم کالا ندارد';
    }

    /**
     * @return bool
     */
    public function selected(): bool
    {
        return $this->selected == self::SELECTED;
    }

    // ********************************************* FA Properties

    /**
     * @return string
     */
    public function getFaPriceIncreaseAmount(): string
    {
        return priceFormat(json_decode($this->value)->price_increase) . ' تومان ' ?? 0;
    }

    /**
     * @return string|array
     */
    public function getFaValue(): string|array
    {
        return convertEnglishToPersian(json_decode($this->value)->value) ?? '-';
    }

    /**
     * @return string
     */
    public function generateFaValue(): string
    {
        return $this->getFaValue() . ' ' . $this->attribute->unit;
    }

    /**
     * @return string
     */
    public function generateEnValue(): string
    {
        return json_decode($this->value)->value . ' ' . $this->attribute->unit_en;
    }

    /**
     * @return string
     */
    public function generateFaFullInformation(): string
    {
        return $this->attribute->name . ' : ' . $this->generateFaValue();
    }

    /**
     * @return string
     */
    public function generateEnFullInformation(): string
    {
        return $this->attribute->name_en . ' : ' . $this->generateEnValue();
    }
}

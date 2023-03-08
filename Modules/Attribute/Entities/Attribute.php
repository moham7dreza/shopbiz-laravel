<?php

namespace Modules\Attribute\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Modules\Attribute\Traits\AttributeRoutesTrait;
use Modules\Attribute\Traits\HasTypesTrait;
use Modules\Category\Entities\ProductCategory;
use Modules\Share\Traits\HasDefaultStatus;

class Attribute extends Model
{
    use HasFactory, SoftDeletes, HasDefaultStatus, HasTypesTrait;

    /**
     * @var string[]
     */
    protected $fillable = ['name', 'name_en', 'type', 'unit', 'unit_en', 'status'];

    // ********************************************* Relations

    /**
     * @return BelongsToMany
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(ProductCategory::class, 'attribute_category', relatedPivotKey: 'category_id');
    }

    /**
     * @return HasMany
     */
    public function values(): HasMany
    {
        return $this->hasMany(AttributeValue::class);
    }

    // ********************************************* methods

    /**
     * @param int $size
     * @return string
     */
    public function getLimitedName(int $size = 50): string
    {
        return Str::limit($this->name, $size) ?? '-';
    }

    // ********************************************* FA Properties

}

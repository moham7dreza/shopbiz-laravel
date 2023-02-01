<?php

namespace Modules\Attribute\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Category\Entities\ProductCategory;
use Modules\Share\Traits\HasDefaultStatus;

class Attribute extends Model
{
    use HasFactory, SoftDeletes, HasDefaultStatus;

    /**
     * @var string[]
     */
    protected $fillable = ['name', 'type', 'unit', 'status'];

    // Relations

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
}

<?php

namespace Modules\Attribute\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Category\Entities\ProductCategory;

class CategoryAttribute extends Model
{

    use HasFactory, SoftDeletes;

    /**
     * @var string[]
     */
    protected $fillable = ['name', 'type', 'unit', 'category_id'];


    // Relations

    /**
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class);
    }

    /**
     * @return HasMany
     */
    public function values(): HasMany
    {
        return $this->hasMany(CategoryValue::class);
    }

    // Methods

    /**
     * @return string
     */
    public function textCategoryName(): string
    {
        return $this->category->name ?? 'دسته ندارد';
    }
}

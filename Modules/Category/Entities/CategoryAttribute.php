<?php

namespace Modules\Category\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CategoryAttribute extends Model
{

    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'type', 'unit', 'category_id'];


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

}

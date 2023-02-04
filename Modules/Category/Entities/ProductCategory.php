<?php

namespace Modules\Category\Entities;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Attribute\Entities\Attribute;
use Modules\Product\Entities\Product;
use Modules\Share\Traits\HasCountersTrait;
use Modules\Share\Traits\HasDefaultStatus;
use Modules\Share\Traits\HasFaDate;
use Modules\Share\Traits\HasFaPropertiesTrait;
use Modules\Share\Traits\HasImageTrait;
use Spatie\Tags\HasTags;


class ProductCategory extends Model
{
    use HasFactory, SoftDeletes, Sluggable, HasFaDate, HasDefaultStatus, HasTags;

    public const SHOW_IN_MENU = 1;
    public const SHOW_NOT_IN_MENU = 0;

    /**
     * @return array[]
     */
    public function sluggable(): array
    {
        return[
            'slug' =>[
                'source' => 'name'
            ]
        ];
    }

    /**
     * @var string[]
     */
    protected $casts = ['image' => 'array'];

    /**
     * @var string[]
     */
    protected $fillable = ['name', 'description', 'slug', 'image', 'status', 'show_in_menu', 'parent_id'];

    // ********************************************* Relations

    /**
     * @return BelongsTo
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo($this, 'parent_id')->with('parent');
    }

    /**
     * @return HasMany
     */
    public function children(): HasMany
    {
        return $this->hasMany($this, 'parent_id')->with('children');
    }

    /**
     * @return HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'category_id');
    }

    /**
     * @return BelongsToMany
     */
    public function attributes(): BelongsToMany
    {
        return $this->belongsToMany(Attribute::class, 'attribute_category', foreignPivotKey: 'category_id');
    }

    // ********************************************* Methods

    /**
     * @return string
     */
    public function getParentName(): string
    {
        return is_null($this->parent_id) ? 'دسته اصلی' : $this->parent->name;
    }

    /**
     * @return mixed|string
     */
    public function getTagLessDescription(): mixed
    {
        return strip_tags($this->description) ?? $this->description ?? '-';
    }

    // ********************************************* paths

    /**
     * @param string $size
     * @return string
     */
    public function getImagePath(string $size = 'medium'): string
    {
        return asset($this->image['indexArray'][$size]);
    }

    /**
     * @return string
     */
    public function customerPath(): string
    {
        return route('customer.market.category.products', $this->slug);
    }

    // ********************************************* FA Properties


}

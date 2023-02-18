<?php

namespace Modules\Category\Entities;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Modules\Post\Entities\Post;
use Modules\Share\Traits\HasDefaultStatus;
use Modules\Share\Traits\HasFaDate;
use Spatie\Tags\HasTags;


class PostCategory extends Model
{
    use HasFactory, SoftDeletes, Sluggable, HasFaDate, HasDefaultStatus, HasTags;

    /**
     * @return array[]
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
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
    protected $fillable = ['name', 'description', 'slug', 'image', 'status'];

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
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'category_id');
    }

    // ********************************************* Methods

    /**
     * @param int $size
     * @return string
     */
    public function getLimitedDescription(int $size = 50): string
    {
        return Str::limit($this->description, $size) ?? '-';
    }

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
     * @return string
     */
    public function path(): string
    {
        return route('category.posts', $this->slug);
    }

    /**
     * @param string $size
     * @return string
     */
    public function getImagePath(string $size = 'medium'): string
    {
        return asset($this->image['indexArray'][$size]);
    }

    // ********************************************* FA Properties

    // ********************************************* FA counters

    /**
     * @return array|int|string
     */
    public function getFaProductsCount(): array|int|string
    {
        return convertEnglishToPersian($this->products->count()) ?? 0;
    }

}

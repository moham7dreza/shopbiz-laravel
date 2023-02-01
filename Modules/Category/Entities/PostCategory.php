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


class PostCategory extends Model
{
    use HasFactory, SoftDeletes, Sluggable, HasFaDate, HasDefaultStatus;

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
    protected $fillable = ['name', 'description', 'slug', 'image', 'status', 'tags'];

    //relations

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

    // Methods

    /**
     * @return string
     */
    public function path(): string
    {
        return route('category.posts', $this->slug);
    }

    /**
     * @return string
     */
    public function limitedDescription(): string
    {
        return Str::limit($this->description, 50);
    }

    /**
     * @return string
     */
    public function getParent(): string
    {
        return is_null($this->parent_id) ? 'دسته اصلی' : $this->parent->name;
    }

    /**
     * @return string
     */
    public function imagePath(): string
    {
        return asset($this->image['indexArray']['medium']);
    }

    /**
     * @return array|int|string
     */
    public function postsCount(): array|int|string
    {
        return convertEnglishToPersian($this->posts->count()) ?? 0;
    }
}

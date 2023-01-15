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
use Modules\Share\Traits\HasFaDate;


class PostCategory extends Model
{
    use HasFactory, SoftDeletes, Sluggable, HasFaDate;

    public const STATUS_ACTIVE = 1;
    public const STATUS_INACTIVE = 0;

    /**
     * @var array|int[]
     */
    public static array $statuses = [self::STATUS_ACTIVE, self::STATUS_INACTIVE];

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
        return $this->hasMany(Post::class);
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
    public function textStatus(): string
    {
        return $this->status === self::STATUS_ACTIVE ? 'فعال' : 'غیر فعال';
    }

    /**
     * @return string
     */
    public function imagePath(): string
    {
        return asset($this->image['indexArray']['medium']);
    }

    /**
     * @return string
     */
    public function cssStatus(): string
    {
        if ($this->status === self::STATUS_ACTIVE) return 'success';
        else if ($this->status === self::STATUS_INACTIVE) return 'danger';
        else return 'warning';
    }

    /**
     * @return int
     */
    public function postsCount(): int
    {
        return $this->posts->count() ?? 0;
    }
}

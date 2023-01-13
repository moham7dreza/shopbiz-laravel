<?php

namespace Modules\Category\Entities;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Post\Entities\Post;
use Modules\Share\Traits\HasFaDate;


class PostCategory extends Model
{
    use HasFactory, SoftDeletes, Sluggable, HasFaDate;

    public const STATUS_ACTIVE = 1;
    public const STATUS_INACTIVE = 0;
    public static array $statuses = [self::STATUS_ACTIVE, self::STATUS_INACTIVE];

    public function sluggable(): array
    {
        return[
            'slug' =>[
                'source' => 'name'
            ]
        ];
    }

    protected $casts = ['image' => 'array'];

    protected $fillable = ['name', 'description', 'slug', 'image', 'status', 'tags'];

    //relations
    public function parent(): BelongsTo
    {
        return $this->belongsTo($this, 'parent_id')->with('parent');
    }

    public function children(): HasMany
    {
        return $this->hasMany($this, 'parent_id')->with('children');
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    // Methods
    public function path(): string
    {
        return route('category.posts', $this->slug);
    }

    public function getParent(): string
    {
        return is_null($this->parent_id) ? 'دسته اصلی' : $this->parent->name;
    }

    public function textStatus(): string
    {
        return $this->status === self::STATUS_ACTIVE ? 'فعال' : 'غیر فعال';
    }

    public function imagePath(): string
    {
        return asset($this->image['indexArray']['medium']);
    }

    public function cssStatus(): string
    {
        if ($this->status === self::STATUS_ACTIVE) return 'success';
        else if ($this->status === self::STATUS_INACTIVE) return 'danger';
        else return 'warning';
    }

    public function postsCount(): int
    {
        return $this->posts->count() ?? 0;
    }
}

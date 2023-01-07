<?php

namespace Modules\Post\Entities;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Modules\Category\Entities\PostCategory;
use Modules\Share\Traits\HasComment;
use Modules\Share\Traits\HasFaDate;
use Modules\User\Entities\User;

class Post extends Model
{
    use HasFactory, SoftDeletes, Sluggable, HasFaDate, HasComment;

    public const STATUS_ACTIVE = 1;
    public const STATUS_PENDING = 2;
    public const STATUS_INACTIVE = 0;
    public static array $statuses = [self::STATUS_ACTIVE, self::STATUS_PENDING, self::STATUS_INACTIVE];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    protected $casts = ['image' => 'array'];
    protected $fillable = ['title', 'summary', 'slug', 'image', 'status', 'tags', 'body', 'published_at', 'author_id', 'category_id', 'commentable'];

    // Relations
    public function postCategory(): BelongsTo
    {
        return $this->belongsTo(PostCategory::class, 'category_id');
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    // Methods
    public function path(): string
    {
        return route('post.detail', $this->slug);
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

    public function textStatus(): string
    {
        return $this->status === self::STATUS_ACTIVE ? 'فعال' : 'غیر فعال';
    }

    public function limitedTitle(): string
    {
        return Str::limit($this->title, 50);
    }

    public function limitedSummary(): string
    {
        return Str::limit($this->summary, 150);
    }

    public function limitedBody(): string
    {
        return Str::limit($this->body, 150);
    }

    public function textCategoryName(): string
    {
        return $this->category->name ?? 'دسته ندارد';
    }

    public function getCategoryPath(): string
    {
        return $this->category->path();
    }

    public function textAuthorName(): string
    {
        return $this->author->fullName ?? 'نویسنده ندارد.';
    }

    public function getAuthorPath(): string
    {
        return $this->author->path();
    }

    public function authorImage(): string
    {
        return $this->author->image() ?? 'عکس ندارد.';
    }
}

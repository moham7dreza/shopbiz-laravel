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
use Modules\Share\Traits\HasStatus;
use Modules\User\Entities\User;

class Post extends Model
{
    use HasFactory, SoftDeletes, Sluggable, HasFaDate, HasComment;

    public const STATUS_ACTIVE = 1;
    public const STATUS_PENDING = 2;
    public const STATUS_INACTIVE = 0;

    public const IS_COMMENTABLE = 1;
    public const IS_NOT_COMMENTABLE = 0;


    /**
     * @var array|int[]
     */
    public static array $statuses = [self::STATUS_ACTIVE, self::STATUS_PENDING, self::STATUS_INACTIVE];

    /**
     * @return array[]
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
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
    protected $fillable = ['title', 'summary', 'slug', 'image', 'status', 'tags', 'body', 'published_at', 'author_id', 'category_id', 'commentable'];

    // Relations

    /**
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(PostCategory::class, 'category_id');
    }

    /**
     * @return BelongsTo
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    // Methods

    /**
     * @return string
     */
    public function path(): string
    {
        return route('post.detail', $this->slug);
    }

    /**
     * @param string $size
     * @return string
     */
    public function imagePath(string $size = 'medium'): string
    {
        return asset($this->image['indexArray'][$size]);
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
     * @return string
     */
    public function textStatus(): string
    {
        return $this->status === self::STATUS_ACTIVE ? 'فعال' : 'غیر فعال';
    }

    /**
     * @return string
     */
    public function limitedTitle(): string
    {
        return Str::limit($this->title, 50);
    }

    /**
     * @return string
     */
    public function limitedSummary(): string
    {
        return Str::limit($this->summary, 150);
    }

    /**
     * @return string
     */
    public function limitedBody(): string
    {
        return Str::limit($this->body, 150);
    }

    /**
     * @return string
     */
    public function textCategoryName(): string
    {
        return $this->category->name ?? 'دسته ندارد';
    }

    /**
     * @return string
     */
    public function getCategoryPath(): string
    {
        return $this->category->path();
    }

    /**
     * @return string
     */
    public function textAuthorName(): string
    {
        return $this->author->fullName ?? 'نویسنده ندارد.';
    }

    /**
     * @return string
     */
    public function getAuthorPath(): string
    {
        return $this->author->path();
    }

    /**
     * @return string
     */
    public function authorImage(): string
    {
        return $this->author->image() ?? 'عکس ندارد.';
    }

    /**
     * @return string
     */
    public function publishFaDate(): string
    {
        return jalaliDate($this->published_at);
    }

    /**
     * @return int
     */
    public function active(): int
    {
        return Post::STATUS_ACTIVE;
    }

    /**
     * @return int
     */
    public function inActive(): int
    {
        return Post::STATUS_INACTIVE;
    }

    /**
     * @return int
     */
    public function commentable(): int
    {
        return Post::IS_COMMENTABLE;
    }

    /**
     * @return int
     */
    public function isNotCommentable(): int
    {
        return Post::IS_COMMENTABLE;
    }
}

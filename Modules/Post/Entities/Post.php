<?php

namespace Modules\Post\Entities;

use Cviebrock\EloquentSluggable\Sluggable;
use CyrildeWit\EloquentViewable\Contracts\Viewable;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Modules\Category\Entities\PostCategory;
use Modules\Share\Traits\HasComment;
use Modules\Share\Traits\HasCountersTrait;
use Modules\Share\Traits\HasFaDate;
use Modules\Share\Traits\HasDefaultStatus;
use Modules\User\Entities\User;
use Overtrue\LaravelFavorite\Traits\Favoriteable;
use Overtrue\LaravelLike\Traits\Likeable;
use Spatie\Tags\HasTags;

class Post extends Model implements Viewable
{
    use HasFactory, SoftDeletes, Sluggable, HasTags,
        HasFaDate, HasComment, HasDefaultStatus, HasCountersTrait,
        InteractsWithViews, Likeable, Favoriteable;

    public const STATUS_PENDING = 2;

    public const IS_COMMENTABLE = 1;
    public const IS_NOT_COMMENTABLE = 0;

    // Booted
    /**
     * Boot post model.
     */
//    public static function boot()
//    {
//        parent::boot();
//
//        static::deleting(static function($article) {
//            $article->categories()->delete();
//            $article->tags()->delete();
//        });
//    }

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

    // paths
    /**
     * @return string
     */
    public function path(): string
    {
        return route('customer.post.detail', $this->slug);
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
    public function getCategoryPath(): string
    {
        return $this->category->path();
    }

    // text property

    /**
     * @return string
     */
    public function limitedTitle(): string
    {
        return Str::limit($this->title, 50);
    }

    /**
     * @param int $limit
     * @return string
     */
    public function limitedSummary(int $limit = 150): string
    {
        return strip_tags(Str::limit($this->summary, $limit));
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
    public function commentable(): int
    {
        return self::IS_COMMENTABLE;
    }

    /**
     * @return int
     */
    public function isNotCommentable(): int
    {
        return self::IS_COMMENTABLE;
    }

    /**
     * @return mixed|string
     */
    public function tagLessSummary(): mixed
    {
        return strip_tags($this->summary) ?? $this->summary ?? '-';
    }
}

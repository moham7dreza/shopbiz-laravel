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
use Modules\Share\Traits\HasFaPropertiesTrait;
use Modules\Share\Traits\HasImageTrait;
use Modules\User\Entities\User;
use Overtrue\LaravelFavorite\Traits\Favoriteable;
use Overtrue\LaravelLike\Traits\Likeable;
use Spatie\Tags\HasTags;

class Post extends Model implements Viewable
{
    use HasFactory, SoftDeletes, Sluggable, HasTags,
        HasFaDate, HasComment, HasDefaultStatus, HasCountersTrait,
        InteractsWithViews, Likeable, Favoriteable,
        HasFaPropertiesTrait, HasImageTrait;

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
    protected $fillable = ['title', 'summary', 'slug', 'image', 'status', 'body', 'published_at', 'author_id', 'category_id', 'commentable'];

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
     * @return string
     */
    public function getCategoryPath(): string
    {
        return $this->category->path();
    }

    /**
     * @return string
     */
    public function getAuthorPath(): string
    {
        return $this->author->path();
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
}

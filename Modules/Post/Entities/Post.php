<?php

namespace Modules\Post\Entities;

use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use CyrildeWit\EloquentViewable\Contracts\Viewable;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Modules\Category\Entities\PostCategory;
use Modules\Share\Traits\HasComment;
use Modules\Share\Traits\HasCountersTrait;
use Modules\Share\Traits\HasFaDate;
use Modules\Share\Traits\HasDefaultStatus;

use Modules\Share\Traits\HasImageTrait;
use Modules\User\Entities\User;
use Overtrue\LaravelFavorite\Traits\Favoriteable;
use Overtrue\LaravelLike\Traits\Likeable;
use Spatie\Tags\HasTags;

class Post extends Model implements Viewable
{
    use HasFactory, SoftDeletes, Sluggable, HasTags,
        HasFaDate, HasComment, HasDefaultStatus,
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
    protected $fillable = ['title', 'summary', 'slug', 'image', 'status', 'body',
        'published_at', 'author_id', 'category_id', 'commentable', 'time_to_read', 'keywords'];

    // ********************************* scope

    /**
     * @param $query
     * @param int $commentable
     * @return mixed
     */
    public function scopeCommentable($query, int $commentable = self::IS_COMMENTABLE): mixed
    {
        return $query->where('commentable', $commentable);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeReadyForPublish($query): mixed
    {
        return $query->where([
            ['status', self::STATUS_ACTIVE],
            ['commentable', self::IS_COMMENTABLE],
            ['published_at', '<', now()]
        ]);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeNotPublished($query): mixed
    {
        return $query->where('published_at', '>', now());
    }

    // ********************************************* Relations

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

    /**
     * Relation to product_rates table, one to many.
     *
     * @return MorphMany
     */
    public function reviews(): MorphMany
    {
        return $this->morphMany('Modules\Post\Entities\Post', 'reviewable');
    }

    // ********************************************* Methods

    /**
     * @return bool
     */
    public function published(): bool
    {
        return $this->published_at < Carbon::now();
    }

    /**
     * @param int $size
     * @return string
     */
    public function getLimitedKeywords(int $size = 50): string
    {
        return Str::limit($this->keywords, $size);
    }

    /**
     * @param int $size
     * @return string
     */
    public function getLimitedTitle(int $size = 50): string
    {
        return Str::limit($this->title, $size);
    }

    /**
     * @param int $size
     * @return string
     */
    public function getLimitedSummary(int $size = 150): string
    {
        return strip_tags(Str::limit($this->summary, $size));
    }

    /**
     * @param int $size
     * @return string
     */
    public function getLimitedBody(int $size = 150): string
    {
        return strip_tags(Str::limit($this->body, $size));
    }

    /**
     * @return string
     */
    public function getCategoryName(): string
    {
        return $this->category->name ?? 'دسته ندارد';
    }

    /**
     * @return string
     */
    public function getAuthorName(): string
    {
        return $this->author->fullName ?? 'نویسنده ندارد.';
    }

    /**
     * @return mixed|string
     */
    public function getTagLessSummary(): mixed
    {
        return strip_tags($this->summary) ?? $this->summary ?? '-';
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

    // ********************************************* paths


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
    public function getAuthorImage(): string
    {
        return $this->author->image() ?? 'عکس ندارد.';
    }

    // ********************************************* FA Properties

    /**
     * @return string
     */
    public function getFaPublishDate(): string
    {
        return jalaliDate($this->published_at);
    }

    // ********************************************* FA counters

    /**
     * @return array|int|string
     */
    public function getFaViewsCount(): array|int|string
    {
        return convertEnglishToPersian(views($this)->unique()->count()) ?? 0;
    }

    /**
     * @return array|int|string
     */
    public function getFaLikersCount(): array|int|string
    {
        return convertEnglishToPersian($this->likers()->count()) ?? 0;
    }
}

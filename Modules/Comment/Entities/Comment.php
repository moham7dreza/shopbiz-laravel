<?php

namespace Modules\Comment\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Modules\Share\Traits\HasDefaultStatus;
use Modules\Share\Traits\HasFaDate;
use Modules\Share\Traits\HasFaPropertiesTrait;
use Modules\Share\Traits\HasImageTrait;
use Modules\User\Entities\User;

class Comment extends Model
{
    use HasFactory, SoftDeletes, HasFaDate, HasDefaultStatus;
    public const STATUS_NEW = 2;

    public const APPROVED = 1;
    public const NOT_APPROVED = 0;

    public const SEEN = 1;
    public const UNSEEN = 0;

    /**
     * @var string[]
     */
    protected $fillable = ['body', 'parent_id', 'author_id', 'commentable_id', 'commentable_type', 'approved', 'status'];

    // ********************************** scope

    /**
     * @param $query
     * @param int $seen
     * @return mixed
     */
    public function scopeSeen($query, int $seen = self::SEEN): mixed
    {
        return $query->where('seen', $seen);
    }

    /**
     * @param $query
     * @param int $approved
     * @return mixed
     */
    public function scopeApproved($query, int $approved = self::SEEN): mixed
    {
        return $query->where('approved', $approved);
    }

    /**
     * @param $query
     * @param int $approved
     * @return mixed
     */
    public function scopeAll($query, int $approved = self::SEEN): mixed
    {
        return $query->where([
            ['status', self::STATUS_ACTIVE],
            ['approved', self::APPROVED],
            ['parent_id', null]
        ]);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeProduct($query): mixed
    {
        return $query->where([
            ['status', self::STATUS_ACTIVE],
            ['approved', self::APPROVED],
            ['commentable_type', 'Modules\Product\Entities\Product'],
            ['parent_id', null]
        ]);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopePost($query): mixed
    {
        return $query->where([
            ['status', self::STATUS_ACTIVE],
            ['approved', self::APPROVED],
            ['commentable_type', 'Modules\Post\Entities\Post'],
            ['parent_id', null]
        ]);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeProductType($query): mixed
    {
        return $query->where('commentable_type', 'Modules\Product\Entities\Product');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopePostType($query): mixed
    {
        return $query->where('commentable_type', 'Modules\Post\Entities\Post');
    }

    // ********************************************* Relations

    /**
     * @return MorphTo
     */
    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * @return BelongsTo
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo($this, 'parent_id');
    }

    /**
     * @return HasMany
     */
    public function answers(): HasMany
    {
        return $this->hasMany($this, 'parent_id');
    }

    // ********************************************* Methods

    /**
     * @param int $size
     * @return string
     */
    public function getLimitedBody(int $size = 50): string
    {
        return Str::limit($this->body, $size) ?? '-';
    }

    /**
     * @return string
     */
    public function getAuthorName(): string
    {
        return $this->user->fullName ?? 'نویسنده ندارد.';
    }

    /**
     * @return string
     */
    public function getParentName(): string
    {
        return is_null($this->parent_id) ? 'نظر اصلی' : $this->parent->name;
    }

    /**
     * @param int $size
     * @return string
     */
    public function getParentBody(int $size = 100): string
    {
        return is_null($this->parent_id) ? '-' : Str::limit($this->parent->body, $size);
    }

    // ********************************************* css

    /**
     * @return string
     */
    public function cssApprove(): string
    {
        if ($this->approved === self::APPROVED) return 'success';
        else if ($this->approved === self::NOT_APPROVED) return 'danger';
        else return 'warning';
    }

    /**
     * @return string
     */
    public function btnCssApprove(): string
    {
        if ($this->approved === self::APPROVED) return 'danger';
        else if ($this->approved === self::NOT_APPROVED) return 'success';
        else return 'warning';
    }

    // ********************************************* paths

    /**
     * @return string
     */
    public function getAuthorImage(): string
    {
        return $this->user->image() ?? 'عکس ندارد.';
    }

    /**
     * @return string
     */
    public function getAuthorPath(): string
    {
        return $this->user->path();
    }


    // ********************************************* FA Properties

    /**
     * @return string
     */
    public function getFaApproved(): string
    {
        return $this->approved === self::APPROVED ? 'تایید شده' : 'تایید نشده';
    }

    /**
     * @return array|mixed|string|string[]
     */
    public function getFaAuthorId(): mixed
    {
        return convertEnglishToPersian($this->author_id) ?? $this->author_id;
    }

    // ********************************************* FA counters

    /**
     * @return string
     */
    public function getFaAuthorPostsCount(): string
    {
        return convertEnglishToPersian($this->user->posts->count()) ?? 0;
    }

    /**
     * @return int
     */
    public function getFaAuthorCommentsCount(): int
    {
        return $this->user->comments->count() ?? 0;
    }

    /**
     * @return array|int|string
     */
    public function getFaAnswersCount(): array|int|string
    {
        return convertEnglishToPersian($this->answers->count()) ?? 0;
    }

    // ********************************************* polymorphic

    /**
     * @return string
     */
    public function getCommentableName(): string
    {
        return Str::limit($this->commentable->title, 50) ?? Str::limit($this->commentable->name, 50) ?? 'عنوانی ندارد';
    }

    /**
     * @return array|mixed|string|string[]
     */
    public function getFaCommentableId(): mixed
    {
        return convertEnglishToPersian($this->commentable_id) ?? $this->commentable_id;
    }

    /**
     * @return string
     */
    public function getCommentablePath(): string
    {
        return $this->commentable->path();
    }

    /**
     * @return string
     */
    public function ObjectPath(): string
    {
        $modelObject = $this->commentable_type::query()->findOrFail($this->commentable_id);
        if (is_null($modelObject)) {
            return '#';
        }
        if ($this->commentable_type == 'Modules\Product\Entities\Product')
            return route('customer.market.product', $modelObject);
        else if ($this->commentable_type == 'Modules\Post\Entities\Post\Post')
            return route('digital-world.post.detail', $modelObject);
        else return '#';
    }

    /**
     * @return string
     */
    public function commentAdminPath(): string
    {
        if ($this->commentable_type == 'Modules\Product\Entities\Product')
            return route('productComment.index');
        else if ($this->commentable_type == 'Modules\Post\Entities\Post')
            return route('postComment.index');
        else return '#';
    }
}

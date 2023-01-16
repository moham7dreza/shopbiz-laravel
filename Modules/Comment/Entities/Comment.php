<?php

namespace Modules\Comment\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Modules\Share\Traits\HasFaDate;
use Modules\User\Entities\User;

class Comment extends Model
{
    use HasFactory, SoftDeletes, HasFaDate;

    public const STATUS_ACTIVE = 1;
    public const STATUS_INACTIVE = 0;
    public const STATUS_NEW = 2;

    public const APPROVED = 1;
    public const NOT_APPROVED = 0;

    public const SEEN = 1;
    public const UNSEEN = 0;

    /**
     * @var array|int[]
     */
    public static array $statuses = [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_NEW];

    /**
     * @var string[]
     */
    protected $fillable = ['body', 'parent_id', 'author_id', 'commentable_id', 'commentable_type', 'approved', 'status'];

    //relations

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

    //methods

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
    public function btnCssStatus(): string
    {
        if ($this->status === self::STATUS_ACTIVE) return 'danger';
        else if ($this->status === self::STATUS_INACTIVE) return 'success';
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

    /**
     * @return string
     */
    public function textApprove(): string
    {
        return $this->approved === self::APPROVED ? 'تایید شده' : 'تایید نشده';
    }

    /**
     * @return string
     */
    public function limitedBody(): string
    {
        return Str::limit($this->body);
    }

    /**
     * @return string
     */
    public function textAuthorName(): string
    {
        return $this->user->fullName ?? 'نویسنده ندارد.';
    }

    /**
     * @return array|mixed|string|string[]
     */
    public function authorId(): mixed
    {
        return convertEnglishToPersian($this->author_id) ?? $this->author_id;
    }

    /**
     * @return string
     */
    public function authorImage(): string
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

    /**
     * @return string
     */
    public function getAuthorPostsCount(): string
    {
        return convertEnglishToPersian($this->user->posts->count()) ?? 0;
    }

    /**
     * @return int
     */
    public function getAuthorCommentsCount(): int
    {
        return $this->user->comments->count() ?? 0;
    }

    /**
     * @return string
     */
    public function textParentName(): string
    {
        return is_null($this->parent_id) ? 'نظر اصلی' : $this->parent->name;
    }

    /**
     * @return string
     */
    public function textParentBody(): string
    {
        return is_null($this->parent_id) ? '-' : Str::limit($this->parent->body);
    }

    /**
     * @return int
     */
    public function answersCount(): int
    {
        return $this->answers->count() ?? 0;
    }

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
    public function commentableId(): mixed
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

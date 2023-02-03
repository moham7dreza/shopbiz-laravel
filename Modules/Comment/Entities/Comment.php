<?php

namespace Modules\Comment\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Share\Traits\HasDefaultStatus;
use Modules\Share\Traits\HasFaDate;
use Modules\Share\Traits\HasFaPropertiesTrait;
use Modules\Share\Traits\HasImageTrait;
use Modules\User\Entities\User;

class Comment extends Model
{
    use HasFactory, SoftDeletes, HasFaDate, HasDefaultStatus, HasFaPropertiesTrait, HasImageTrait;
    public const STATUS_NEW = 2;

    public const APPROVED = 1;
    public const NOT_APPROVED = 0;

    public const SEEN = 1;
    public const UNSEEN = 0;

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
    public function getAuthorPath(): string
    {
        return $this->user->path();
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

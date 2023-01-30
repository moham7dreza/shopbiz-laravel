<?php

namespace Modules\Share\Traits;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasRelationships;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Modules\Comment\Entities\Comment;

trait HasComment
{
    use HasRelationships;

    /**
     * @return MorphMany
     */
    public function comments(): MorphMany
    {
        return $this->morphMany('Modules\Comment\Entities\Comment', 'commentable');
    }

    /**
     * @return Collection
     */
    public function activeComments(): Collection
    {
        return $this->comments()->where([
            ['approved', Comment::APPROVED],
            ['status', Comment::STATUS_ACTIVE],
            ['parent_id', null]
        ])->get();
    }

    /**
     * @return Collection
     */
    public function allActivePostComments(): Collection
    {
        return $this->comments()->where([
            ['approved', Comment::APPROVED],
            ['status', Comment::STATUS_ACTIVE],
            ['commentable_type', 'Modules\Post\Entities\Post']
        ])->get();
    }

    /**
     * @return Collection
     */
    public function allActiveProductComments(): Collection
    {
        return $this->comments()->where([
            ['approved', Comment::APPROVED],
            ['status', Comment::STATUS_ACTIVE],
            ['commentable_type', 'Modules\Product\Entities\Product']
        ])->get();
    }

    /**
     * @return array|int|string
     */
    public function allActivePostCommentsCount(): array|int|string
    {
        return convertEnglishToPersian($this->allActivePostComments()->count()) ?? 0;
    }

    /**
     * @return array|int|string
     */
    public function allActiveProductCommentsCount(): array|int|string
    {
        return convertEnglishToPersian($this->allActiveProductComments()->count()) ?? 0;
    }
}

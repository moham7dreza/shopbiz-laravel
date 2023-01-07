<?php

namespace Modules\Share\Traits;

use Illuminate\Database\Eloquent\Concerns\HasRelationships;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Modules\Comment\Entities\Comment;

trait HasComment
{
    use HasRelationships;

    public function comments(): MorphMany
    {
        return $this->morphMany('Modules\Comment\Entities\Comment', 'commentable');
    }

    public function activeComments(): MorphMany
    {
        return $this->comments()->where([['approved', Comment::APPROVED]
            , ['status', Comment::STATUS_ACTIVE]])->whereNull('parent_id');
    }
}

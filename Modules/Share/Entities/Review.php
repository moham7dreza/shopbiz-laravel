<?php

namespace Modules\Share\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Modules\User\Entities\User;

class Review extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'reviewable_id', 'reviewable_type', 'rate'];

    /**
     * @return MorphTo
     */
    public function reviewable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return mixed
     */
    public function path(): mixed
    {
        return $this->reviewable->path();
    }
}

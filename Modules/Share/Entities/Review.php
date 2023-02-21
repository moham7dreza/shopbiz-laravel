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

    // ********************************************* scopes

    /**
     * @param $query
     * @return mixed
     */
    public function scopeProductType($query): mixed
    {
        return $query->where('reviewable_type', 'Modules\Product\Entities\Product');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopePostType($query): mixed
    {
        return $query->where('reviewable_type', 'Modules\Post\Entities\Post');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeUser($query): mixed
    {
        return $query->where('user_id', auth()->id());
    }

    // ********************************************* Relations

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
// ********************************************* Methods



// ********************************************* paths
    /**
     * @return mixed
     */
    public function path(): mixed
    {
        return $this->reviewable->path();
    }
}

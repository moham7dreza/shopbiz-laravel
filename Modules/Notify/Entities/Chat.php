<?php

namespace Modules\Notify\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Modules\Share\Traits\HasDefaultStatus;
use Modules\Share\Traits\HasFaDate;

class Chat extends Model
{
    use HasDefaultStatus, SoftDeletes, HasFaDate;

    /**
     * @var string[]
     */
    protected $fillable = ['email', 'mobile', 'status', 'seen', 'reference_id', 'message', 'parent_id'];

    // ********************************* scope

    /**
     * @param $query
     * @return mixed
     */
    public function scopeParent($query): mixed
    {
        return $query->where('parent_id', null);
    }

    // ********************************************* Relations

    /**
     * @return BelongsTo
     */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(ChatAdmin::class, 'reference_id');
    }


    /**
     * @return BelongsTo
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo($this, 'parent_id')->with('parent');
    }

    /**
     * @return HasMany
     */
    public function children(): HasMany
    {
        return $this->hasMany($this, 'parent_id')->with('children');
    }

    /**
     *
     * @return MorphMany
     */
    public function files(): MorphMany
    {
        return $this->morphMany('Modules\Share\Entities\File', 'fileable');
    }

    // ********************************************* Methods

    /**
     * @param int $limit
     * @return string
     */
    public function getLimitedMessage(int $limit = 50): string
    {
        return Str::limit($this->message, $limit);
    }

    /**
     * @return array|string
     */
    public function getFaPhone(): array|string
    {
        return !is_null($this->mobile) ? convertEnglishToPersian($this->mobile) : '-';
    }

    /**
     * @return string
     */
    public function getParentTitle(): string
    {
        return !empty($this->parent->message) ? Str::limit($this->parent->message, 50) : '-';
    }

    /**
     * @return string
     */
    public function getReferenceName(): string
    {
        return $this->admin->user->fullName ?? $this->admin->user->first_name ?? '-';
    }
}

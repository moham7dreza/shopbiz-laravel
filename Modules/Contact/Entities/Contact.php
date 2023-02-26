<?php

namespace Modules\Contact\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Share\Traits\HasDefaultStatus;
use Modules\Share\Traits\HasFaDate;

class Contact extends Model
{
    use HasFactory, SoftDeletes, HasFaDate, HasDefaultStatus;

    public const IS_READ = 1;
    public const NOT_READ = 0;
    public const APPROVED = 1;
    public const NOT_APPROVED = 0;

    /**
     * Fillable columns.
     *
     * @var string[]
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'phone', 'subject', 'message', 'is_read', 'meet_date',
        'approved', 'status'
    ];

    // ********************************************* Scopes
    /**
     * @param $query
     * @param int $approved
     * @return mixed
     */
    public function scopeApproved($query, int $approved = self::APPROVED): mixed
    {
        return $query->where('approved', $approved);
    }

    /**
     * Scope is_read is true.
     *
     * @param  $query
     * @param int $read
     * @return mixed
     */
    public function scopeRead($query, int $read = self::IS_READ): mixed
    {
        return $query->where('is_read', $read);
    }

    // ********************************************* Relations
    /**
     *
     * @return MorphMany
     */
    public function files(): MorphMany
    {
        return $this->morphMany('Modules\Share\Entities\File', 'fileable');
    }
}

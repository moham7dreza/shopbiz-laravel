<?php

namespace Modules\Contact\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
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

    /**
     * @param $query
     * @return mixed
     */
    public function scopeAppointment($query): mixed
    {
        return $query->whereNotNull('meet_date');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeContact($query): mixed
    {
        return $query->whereNull('meet_date');
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

    // ********************************************* Methods

    /**
     * @return bool
     */
    public function isContactApproved(): bool
    {
        return $this->approved == self::APPROVED;
    }

    /**
     * @return string
     */
    public function getFaChangeApprovedText(): string
    {
        return $this->isContactApproved() ? 'عدم تایید فرم' : 'تایید فرم';
    }

    /**
     * @return string
     */
    public function getFaApprovedText(): string
    {
        return $this->isContactApproved() ? 'تایید شده' : 'تایید نشده';
    }

    /**
     * @return string
     */
    public function getApprovedIcon(): string
    {
        return $this->isContactApproved() ? 'clock' : 'check';
    }

    /**
     * @return string
     */
    public function getApprovedColor(): string
    {
        return $this->isContactApproved() ? 'warning' : 'success';
    }

    /**
     * @param int $limit
     * @return string
     */
    public function getLimitedSubject(int $limit = 50): string
    {
        return Str::limit($this->subject, $limit);
    }

    // ********************************************* fa

    /**
     * @return array|string
     */
    public function getFaPhone(): array|string
    {
        return convertEnglishToPersian($this->phone) ?? '-';
    }

    /**
     * @return string
     */
    public function getFaMeetTime(): string
    {
        return $this->getFaDate($this->meet_date, '%A, %d %B %Y | H:i:s');
    }
}

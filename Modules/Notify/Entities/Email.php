<?php

namespace Modules\Notify\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Modules\Share\Traits\HasDefaultStatus;
use Modules\Share\Traits\HasFaDate;
use Modules\Share\Traits\HasFaPropertiesTrait;

class Email extends Model
{
    protected $table = 'public_mail';

    use HasFactory, SoftDeletes, HasDefaultStatus, HasFaDate;


    /**
     * @var string[]
     */
    protected $fillable = ['subject', 'body', 'status', 'published_at'];

    // ********************************************* Relations

    /**
     * @return HasMany
     */
    public function files(): HasMany
    {
        return $this->hasMany(EmailFile::class, 'public_mail_id');
    }

    // ********************************************* Methods

    /**
     * @param int $size
     * @return string
     */
    public function getLimitedSubject(int $size = 50): string
    {
        return Str::limit($this->subject, $size);
    }

    /**
     * @param int $size
     * @return string
     */
    public function getLimitedBody(int $size = 50): string
    {
        return Str::limit($this->body, $size);
    }

    /**
     * @return bool
     */
    public function sentStatus(): bool
    {
        return $this->published_at < Carbon::now() && $this->status == $this->statusActive();
    }

    // ********************************************* paths


    // ********************************************* FA Properties
}

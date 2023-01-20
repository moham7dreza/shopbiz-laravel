<?php

namespace Modules\Notify\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Modules\Share\Traits\HasFaDate;
use Modules\Share\Traits\HasStatus;

class Email extends Model
{
    protected $table = 'public_mail';

    use HasFactory, SoftDeletes, HasStatus, HasFaDate;


    /**
     * @var string[]
     */
    protected $fillable = ['subject', 'body', 'status', 'published_at'];

    /**
     * @return HasMany
     */
    public function files(): HasMany
    {
        return $this->hasMany(EmailFile::class, 'public_mail_id');
    }

    /**
     * @return string
     */
    public function limitedSubject(): string
    {
        return Str::limit($this->subject, 50);
    }

    /**
     * @return string
     */
    public function limitedBody(): string
    {
        return Str::limit($this->body, 50);
    }

    /**
     * @return mixed|string
     */
    public function publishFaDate(): mixed
    {
        return jalaliDate($this->published_at, 'H:i:s | Y-m-d') ?? $this->published_at ?? '-';
    }
}

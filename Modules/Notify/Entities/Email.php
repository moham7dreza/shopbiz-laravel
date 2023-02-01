<?php

namespace Modules\Notify\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Modules\Share\Traits\HasFaDate;
use Modules\Share\Traits\HasDefaultStatus;
use Modules\Share\Traits\HasFaPropertiesTrait;

class Email extends Model
{
    protected $table = 'public_mail';

    use HasFactory, SoftDeletes, HasDefaultStatus, HasFaDate, HasFaPropertiesTrait;


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
}

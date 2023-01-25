<?php

namespace Modules\Auth\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Share\Traits\HasFaDate;
use Modules\Share\Traits\HasDefaultStatus;
use Modules\User\Entities\User;

class Otp extends Model
{
    use HasFactory, HasFaDate, HasDefaultStatus;

    public const CODE_USED = 1;
    public const CODE_UN_USED = 0;
    public const TYPE_MOBILE = 0;
    public const TYPE_EMAIL = 1;

    protected $fillable = ['token', 'user_id', 'otp_code', 'login_id', 'type', 'used', 'status'];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

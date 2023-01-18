<?php

namespace Modules\Payment\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Share\Traits\HasFaDate;
use Modules\User\Entities\User;

class Payment extends Model
{
    use HasFactory, SoftDeletes, HasFaDate;

    protected $fillable = ['amount', 'user_id', 'pay_date', 'type', 'paymentable_id', 'paymentable_type', 'status',];

    // Relations

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return MorphTo
     */
    public function paymentable(): MorphTo
    {
        return $this->morphTo();
    }

    // Methods

}

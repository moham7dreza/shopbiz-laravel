<?php

namespace Modules\Payment\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Share\Traits\HasFaDate;

class OnlinePayment extends Model
{
    use HasFactory, SoftDeletes, HasFaDate;

    public const STATUS_ACTIVE = 1;
    public const STATUS_INACTIVE = 0;

    /**
     * @var array|int[]
     */
    public static array $statuses = [self::STATUS_ACTIVE, self::STATUS_INACTIVE];

    protected $fillable = ['amount', 'user_id', 'gateway', 'transaction_id', 'status',
        'bank_first_response', 'bank_second_response'];

    // Relations
    /**
     * @return MorphMany
     */
    public function payments(): MorphMany
    {
        return $this->morphMany('Modules\Payment\Entities\Payment', 'paymentable');
    }
}

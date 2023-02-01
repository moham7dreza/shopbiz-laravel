<?php

namespace Modules\Payment\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Share\Traits\HasDefaultStatus;
use Modules\Share\Traits\HasFaDate;

class CashPayment extends Model
{
    use HasFactory, SoftDeletes, HasFaDate, HasDefaultStatus;


    protected $fillable = ['amount', 'user_id', 'pay_date', 'cash_receiver', 'status',];

    /**
     * @return MorphMany
     */
    public function payments(): MorphMany
    {
        return $this->morphMany('Modules\Payment\Entities\Payment', 'paymentable');
    }
}

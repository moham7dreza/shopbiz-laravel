<?php

namespace Modules\Payment\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Share\Traits\HasDefaultStatus;
use Modules\Share\Traits\HasFaDate;

class OfflinePayment extends Model
{
    use HasFactory, SoftDeletes, HasFaDate, HasDefaultStatus;

    protected $fillable = ['amount', 'user_id', 'pay_date', 'transaction_id', 'status'];

    // ********************************************* Relations

    /**
     * @return MorphMany
     */
    public function payments(): MorphMany
    {
        return $this->morphMany('Modules\Payment\Entities\Payment', 'paymentable');
    }

    // ********************************************* Methods

}

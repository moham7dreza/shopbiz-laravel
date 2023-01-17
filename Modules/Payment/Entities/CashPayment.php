<?php

namespace Modules\Payment\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class CashPayment extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    /**
     * @return MorphMany
     */
    public function payments(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany('Modules\Payment\Entities\Payment', 'paymentable');
    }
}

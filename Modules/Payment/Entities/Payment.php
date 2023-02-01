<?php

namespace Modules\Payment\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Payment\Traits\PaymentStatusTrait;
use Modules\Share\Traits\HasFaDate;
use Modules\User\Entities\User;

class Payment extends Model
{
    use HasFactory, SoftDeletes, HasFaDate, PaymentStatusTrait;

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

    /**
     * @return int|string
     */
    public function transactionId(): int|string
    {
        return convertEnglishToPersian($this->paymentable->transaction_id) ?? '-';
    }

    /**
     * @return string
     */
    public function paymentGateway(): string
    {
        return $this->paymentable->gateway ?? '-';
    }

    /**
     * @return string
     */
    public function customerName(): string
    {
        return $this->user->fullName ?? $this->user->first_name ?? '-';
    }

    /**
     * @return int|string
     */
    public function customerId(): int|string
    {
        return convertEnglishToPersian($this->user->id) ?? '-';
    }

    /**
     * @return int|string
     */
    public function paymentAmountFaPrice(): int|string
    {
        return priceFormat($this->paymentable->amount) . ' تومان' ?? 0;
    }

    /**
     * @return string
     */
    public function payDate(): string
    {
        return jalaliDate($this->paymentable->pay_date) ?? 'تاریخ پرداخت یافت نشد.';
    }

    /**
     * @return string
     */
    public function cashReceiverName(): string
    {
        return $this->paymentable->cash_receiver ?? '-';
    }
}

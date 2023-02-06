<?php

namespace Modules\Payment\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Payment\Traits\PaymentStatusTrait;
use Modules\Share\Traits\HasFaDate;
use Modules\Share\Traits\HasFaPropertiesTrait;
use Modules\User\Entities\User;

class Payment extends Model
{
    use HasFactory, SoftDeletes, HasFaDate, PaymentStatusTrait;

    protected $fillable = ['amount', 'user_id', 'pay_date', 'type', 'paymentable_id', 'paymentable_type', 'status'];

    // ********************************* scope

    /**
     * @param $query
     * @return mixed
     */
    public function scopeOfflineType($query): mixed
    {
        return $query->where('paymentable_type', 'Modules\Payment\Entities\OfflinePayment');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeOnlineType($query): mixed
    {
        return $query->where('paymentable_type', 'Modules\Payment\Entities\OnlinePayment');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeCashType($query): mixed
    {
        return $query->where('paymentable_type', 'Modules\Payment\Entities\CashPayment');
    }

    // ********************************************* Relations

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

    // ********************************************* Methods

    /**
     * @return string
     */
    public function getCustomerName(): string
    {
        return $this->user->fullName ?? $this->user->first_name ?? '-';
    }

    /**
     * @return string
     */
    public function getPaymentGateway(): string
    {
        return $this->paymentable->gateway ?? '-';
    }

    /**
     * @return string
     */
    public function getCashReceiverName(): string
    {
        return $this->paymentable->cash_receiver ?? '-';
    }

    // ********************************************* FA Properties

    /**
     * @return int|string
     */
    public function getFaTransactionId(): int|string
    {
        return convertEnglishToPersian($this->paymentable->transaction_id) ?? '-';
    }

    /**
     * @return int|string
     */
    public function getFaCustomerId(): int|string
    {
        return convertEnglishToPersian($this->user->id) ?? '-';
    }

    /**
     * @return int|string
     */
    public function getFaPaymentAmountPrice(): int|string
    {
        return priceFormat($this->paymentable->amount) . ' تومان' ?? 0;
    }

    /**
     * @return string
     */
    public function getFaPayDate(): string
    {
        return jalaliDate($this->paymentable->pay_date) ?? 'تاریخ پرداخت یافت نشد.';
    }

}

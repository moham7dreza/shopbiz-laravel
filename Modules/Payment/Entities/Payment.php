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

    public const PAYMENT_STATUS_NOT_PAID = 0;
    public const PAYMENT_STATUS_PAID = 1;
    public const PAYMENT_STATUS_CANCELED = 2;
    public const PAYMENT_STATUS_RETURNED = 3;

    /**
     * @var array|int[]
     */
    public static array $paymentStatuses = [self::PAYMENT_STATUS_CANCELED, self::PAYMENT_STATUS_PAID,
        self::PAYMENT_STATUS_RETURNED, self::PAYMENT_STATUS_NOT_PAID];

    public const PAYMENT_TYPE_ONLINE = 0;
    public const PAYMENT_TYPE_OFFLINE = 1;
    public const PAYMENT_TYPE_CASH = 2;

    public static array $paymentTypes = [self::PAYMENT_TYPE_ONLINE, self::PAYMENT_TYPE_CASH, self::PAYMENT_TYPE_OFFLINE];


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
     * @return string
     */
    public function paymentStatusValue(): string
    {
        return match ($this->status) {
            self::PAYMENT_STATUS_NOT_PAID => 'پرداخت نشده',
            self::PAYMENT_STATUS_PAID => 'پرداخت شده',
            self::PAYMENT_STATUS_CANCELED => 'باطل شده',
            default => 'برگشت داده شده',
        };
    }

    /**
     * @return string
     */
    public function paymentTypeValue(): string
    {
        return match ($this->type) {
            self::PAYMENT_TYPE_ONLINE => 'آنلاین',
            self::PAYMENT_TYPE_OFFLINE => 'آفلاین',
            default => 'در محل',
        };
    }

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

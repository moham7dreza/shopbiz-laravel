<?php

namespace Modules\Payment\Traits;

trait PaymentStatusTrait
{
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
}

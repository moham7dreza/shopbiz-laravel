<?php

namespace Modules\Order\Traits;

trait OrderStatusTrait
{
    public const ORDER_STATUS_AWAIT_CONFIRM = 1;
    public const ORDER_STATUS_NOT_CONFIRMED = 2;
    public const ORDER_STATUS_CONFIRMED = 3;
    public const ORDER_STATUS_CANCELED = 4;
    public const ORDER_STATUS_RETURNED = 5;
    public const ORDER_STATUS_NOT_CHECKED = 0;

    public static array $orderStatuses = [self::ORDER_STATUS_AWAIT_CONFIRM, self::ORDER_STATUS_NOT_CONFIRMED,
        self::ORDER_STATUS_CONFIRMED, self::ORDER_STATUS_CANCELED, self::ORDER_STATUS_NOT_CHECKED];

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


    public const DELIVERY_STATUS_NOT_SEND = 0;
    public const DELIVERY_STATUS_SENDING = 1;
    public const DELIVERY_STATUS_SEND = 2;
    public const DELIVERY_STATUS_DELIVERED = 3;

    /**
     * @var array|int[]
     */
    public static array $deliveryStatuses = [
        self::DELIVERY_STATUS_SENDING, self::DELIVERY_STATUS_SEND, self::DELIVERY_STATUS_DELIVERED,
        self::DELIVERY_STATUS_NOT_SEND
    ];

    /**
     * @return string
     */
    public function orderStatusValue(): string
    {
        return match ($this->order_status) {
            self::ORDER_STATUS_AWAIT_CONFIRM => 'در انتظار تایید',
            self::ORDER_STATUS_NOT_CONFIRMED => 'تاییده نشده',
            self::ORDER_STATUS_CONFIRMED => 'تایید شده',
            self::ORDER_STATUS_CANCELED => 'باطل شده',
            self::ORDER_STATUS_RETURNED => 'مرجوع شده',
            default => 'بررسی نشده',
        };
    }

    /**
     * @return string
     */
    public function deliveryStatusValue(): string
    {
        return match ($this->delivery_status) {
            self::DELIVERY_STATUS_NOT_SEND => 'ارسال نشده',
            self::DELIVERY_STATUS_SENDING => 'در حال ارسال',
            self::DELIVERY_STATUS_SEND => 'ارسال شده',
            default => 'تحویل شده',
        };
    }

    /**
     * @return string
     */
    public function paymentStatusValue(): string
    {
        return match ($this->payment_status) {
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
        return match ($this->payment_type) {
            self::PAYMENT_TYPE_ONLINE => 'آنلاین',
            self::PAYMENT_TYPE_OFFLINE => 'آفلاین',
            default => 'در محل',
        };
    }
}

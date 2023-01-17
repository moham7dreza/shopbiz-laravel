<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Address\Entities\Address;
use Modules\Delivery\Entities\Delivery;
use Modules\Discount\Entities\CommonDiscount;
use Modules\Discount\Entities\Copan;
use Modules\Payment\Entities\Payment;
use Modules\Share\Traits\HasFaDate;
use Modules\User\Entities\User;

class Order extends Model
{
    use HasFactory, SoftDeletes, HasFaDate;

    public const PAYMENT_STATUS_NOT_PAID = 0;
    public const PAYMENT_STATUS_PAID = 1;
    public const PAYMENT_STATUS_CANCELED = 2;
    public const PAYMENT_STATUS_RETURNED = 3;
    public const PAYMENT_TYPE_ONLINE = 0;
    public const PAYMENT_TYPE_OFFLINE = 1;
    public const PAYMENT_TYPE_CASH = 2;
    public const DELIVERY_STATUS_NOT_SEND = 0;
    public const DELIVERY_STATUS_SENDING = 1;
    public const DELIVERY_STATUS_SEND = 2;
    public const DELIVERY_STATUS_DELIVERED = 3;
    public const ORDER_STATUS_AWAIT_CONFIRM = 1;
    public const ORDER_STATUS_NOT_CONFIRMED = 2;
    public const ORDER_STATUS_CONFIRMED = 3;
    public const ORDER_STATUS_CANCELED = 4;
    public const ORDER_STATUS_RETURNED = 5;
    public const ORDER_STATUS_NOT_CHECKED = 0;


    protected $fillable = ['order_status', 'user_id', 'address_id', 'payment_id', 'payment_type', 'payment_status',
        'delivery_id', 'delivery_amount', 'delivery_status', 'delivery_date', 'order_final_amount',
        'order_discount_amount', 'copan_id', 'order_copan_discount_amount', 'common_discount_id',
        'order_common_discount_amount', 'order_total_products_discount_amount', 'order_status'
    ];
    // Relations

    /**
     * @return BelongsTo
     */
    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class);
    }

    /**
     * @return BelongsTo
     */
    public function delivery(): BelongsTo
    {
        return $this->belongsTo(Delivery::class);
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo
     */
    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }

    /**
     * @return BelongsTo
     */
    public function copan(): BelongsTo
    {
        return $this->belongsTo(Copan::class);
    }

    /**
     * @return BelongsTo
     */
    public function commonDiscount(): BelongsTo
    {
        return $this->belongsTo(CommonDiscount::class);
    }

    /**
     * @return HasMany
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }


    // Methods

    /**
     * @return string
     */
    public function getPaymentStatusValueAttribute(): string
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
    public function getPaymentTypeValueAttribute(): string
    {
        return match ($this->payment_type) {
            self::PAYMENT_TYPE_ONLINE => 'آنلاین',
            self::PAYMENT_TYPE_OFFLINE => 'آفلاین',
            default => 'در محل',
        };
    }

    /**
     * @return string
     */
    public function getDeliveryStatusValueAttribute(): string
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
    public function getOrderStatusValueAttribute(): string
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
}

<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Delivery\Entities\Delivery;
use Modules\Discount\Entities\CommonDiscount;
use Modules\Discount\Entities\Copan;
use Modules\Payment\Entities\Payment;
use Modules\Share\Traits\HasFaDate;
use Modules\User\Entities\Address;
use Modules\User\Entities\User;

class Order extends Model
{
    use HasFactory, SoftDeletes, HasFaDate;

    protected $guarded = ['id'];


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
            0 => 'پرداخت نشده',
            1 => 'پرداخت شده',
            2 => 'باطل شده',
            default => 'برگشت داده شده',
        };
    }

    /**
     * @return string
     */
    public function getPaymentTypeValueAttribute(): string
    {
        return match ($this->payment_type) {
            0 => 'آنلاین',
            1 => 'آفلاین',
            default => 'در محل',
        };
    }

    /**
     * @return string
     */
    public function getDeliveryStatusValueAttribute(): string
    {
        return match ($this->delivery_status) {
            0 => 'ارسال نشده',
            1 => 'در حال ارسال',
            2 => 'ارسال شده',
            default => 'تحویل شده',
        };
    }


    /**
     * @return string
     */
    public function getOrderStatusValueAttribute(): string
    {
        return match ($this->order_status) {
            1 => 'در انتظار تایید',
            2 => 'تاییده نشده',
            3 => 'تایید شده',
            4 => 'باطل شده',
            5 => 'مرجوع شده',
            default => 'بررسی نشده',
        };
    }
}

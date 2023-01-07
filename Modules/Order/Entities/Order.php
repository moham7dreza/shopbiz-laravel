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
    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class);
    }

    public function delivery(): BelongsTo
    {
        return $this->belongsTo(Delivery::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }

    public function copan(): BelongsTo
    {
        return $this->belongsTo(Copan::class);
    }

    public function commonDiscount(): BelongsTo
    {
        return $this->belongsTo(CommonDiscount::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }


    // Methods
    public function getPaymentStatusValueAttribute(): string
    {
        switch ($this->payment_status) {
            case 0:
                $result = 'پرداخت نشده';
                break;
            case 1:
                $result = 'پرداخت شده';
                break;
            case 2:
                $result = 'باطل شده';
                break;
            default :
                $result = 'برگشت داده شده';
        }
        return $result;
    }

    public function getPaymentTypeValueAttribute(): string
    {
        switch ($this->payment_type) {
            case 0:
                $result = 'آنلاین';
                break;
            case 1:
                $result = 'آفلاین';
                break;
            default :
                $result = 'در محل';
        }
        return $result;
    }

    public function getDeliveryStatusValueAttribute(): string
    {
        switch ($this->delivery_status) {
            case 0:
                $result = 'ارسال نشده';
                break;
            case 1:
                $result = 'در حال ارسال';
                break;
            case 2:
                $result = 'ارسال شده';
                break;
            default :
                $result = 'تحویل شده';
        }
        return $result;
    }


    public function getOrderStatusValueAttribute(): string
    {
        switch ($this->order_status) {
            case 1:
                $result = 'در انتظار تایید';
                break;
            case 2:
                $result = 'تاییده نشده';
                break;
            case 3:
                $result = 'تایید شده';
                break;
            case 4:
                $result = 'باطل شده';
                break;
            case 5:
                $result = 'مرجوع شده';
                break;
            default :
                $result = 'بررسی نشده';
        }
        return $result;
    }


}

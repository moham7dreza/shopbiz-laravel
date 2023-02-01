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
use Modules\Order\Traits\OrderStatusTrait;
use Modules\Payment\Entities\Payment;
use Modules\Share\Traits\HasFaDate;
use Modules\Share\Traits\HasFaPropertiesTrait;
use Modules\User\Entities\User;

class Order extends Model
{
    use HasFactory, SoftDeletes, HasFaDate, OrderStatusTrait, HasFaPropertiesTrait;


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
     * @return array|int|mixed|string
     */
    public function faOrderId(): mixed
    {
        return convertEnglishToPersian($this->id) ?? $this->id ?? 0;
    }

    /**
     * @return string
     */
    public function paymentGateway(): string
    {
        return $this->payment->paymentable->gateway ?? '-';
    }
}

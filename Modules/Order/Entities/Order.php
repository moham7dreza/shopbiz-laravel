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
    use HasFactory, SoftDeletes, HasFaDate, OrderStatusTrait;


    protected $fillable = ['order_status', 'user_id', 'address_id', 'payment_id', 'payment_type', 'payment_status',
        'delivery_id', 'delivery_amount', 'delivery_status', 'delivery_date', 'order_final_amount',
        'order_discount_amount', 'copan_id', 'order_copan_discount_amount', 'common_discount_id',
        'order_common_discount_amount', 'order_total_products_discount_amount', 'order_status'
    ];


    // ********************************************* Relations

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

    // ********************************************* Methods

    /**
     * @return string
     */
    public function getPaymentGateway(): string
    {
        return $this->payment->paymentable->gateway ?? '-';
    }

    /**
     * @return string
     */
    public function getDeliveryMethodName(): string
    {
        return $this->delivery->name ?? '-';
    }

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
    public function getCustomerAddress(): string
    {
        return $this->address->address ?? 'آدرس مشتری یافت نشد.';
    }

    /**
     * @return string
     */
    public function getCustomerCity(): string
    {
        return $this->address->city->name ?? 'آدرس مشتری یافت نشد.';
    }

    /**
     * @return string
     */
    public function getRecipientFName(): string
    {
        return $this->address->recipient_first_name ?? 'نام گیرنده کالا یافت نشد.';
    }

    /**
     * @return string
     */
    public function getRecipientLName(): string
    {
        return $this->address->recipient_last_name ?? 'نام گیرنده کالا یافت نشد.';
    }

    /**
     * @return string
     */
    public function getCustomerUsedCopan(): string
    {
        return $this->copan->code ?? 'کوپن تخفیف ندارد.';
    }

    public function getUsedCommonDiscountTitle()
    {
        return $this->commonDiscount->title ?? 'عنوان تخفیف عمومی یافت نشد.';
    }

    // ********************************************* FA Properties

    /**
     * @return array|int|mixed|string
     */
    public function getFaId(): mixed
    {
        return convertEnglishToPersian($this->id) ?? $this->id ?? 0;
    }

    // price calc
    /**
     * @return int|string
     */
    public function getFaOrderFinalAmountPrice(): int|string
    {
        return priceFormat($this->order_final_amount) . ' تومان' ?? 0;
    }

    /**
     * @return int|string
     */
    public function getFaOrderDiscountAmountPrice(): int|string
    {
        return priceFormat($this->order_discount_amount) . ' تومان' ?? 0;
    }

    /**
     * @return int|string
     */
    public function getFaOrderTotalProductsDiscountAmountPrice(): int|string
    {
        return priceFormat($this->order_total_products_discount_amount) . ' تومان' ?? 0;
    }

    /**
     * @return int|string
     */
    public function getFaOrderFinalPrice(): int|string
    {
        return priceFormat($this->order_final_amount -  $this->order_discount_amount) . ' تومان' ?? 0;
    }

    /**
     * @return int|string
     */
    public function getFaOrderDeliveryAmountPrice(): int|string
    {
        return priceFormat($this->delivery_amount) . ' تومان' ?? 0;
    }

    /**
     * @return int|string
     */
    public function getFaOrderCopanDiscountAmountPrice(): int|string
    {
        return priceFormat($this->order_copan_discount_amount) . ' تومان'
            ?? convertEnglishToPersian(0);
    }

    /**
     * @return int|string
     */
    public function getFaOrderCommonDiscountAmountPrice(): int|string
    {
        return priceFormat($this->order_common_discount_amount) . ' تومان' ?? 0;
    }

    /**
     * @return array|string
     */
    public function getFaCustomerPostalCode(): array|string
    {
        return convertEnglishToPersian($this->address->postal_code) ?? 'کد پستی یافت نشد.';
    }

    /**
     * @return array|string
     */
    public function getFaCustomerUnit(): array|string
    {
        return convertEnglishToPersian($this->address->unit) ?? 'واحد یافت نشد.';
    }

    /**
     * @return array|string
     */
    public function getFaCustomerNo(): array|string
    {
        return convertEnglishToPersian($this->address->no) ?? 'شماره پلاک یافت نشد.';
    }

    /**
     * @return array|string
     */
    public function getFaCustomerMobile(): array|string
    {
        return convertEnglishToPersian($this->address->mobile) ?? 'شماره موبایل یافت نشد.';
    }

    /**
     * @return string
     */
    public function getFaOrderSendDate(): string
    {
        return jalaliDate($this->delivery_time) ?? 'تاریخ ارسال یافت نشد.';
    }
}

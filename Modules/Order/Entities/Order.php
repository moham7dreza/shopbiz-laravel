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

    /**
     * @return array|int|mixed|string
     */
    public function faOrderId(): mixed
    {
        return convertEnglishToPersian($this->id) ?? $this->id ?? 0;
    }

    /**
     * @return int|string
     */
    public function orderFinalAmountFaPrice(): int|string
    {
        return priceFormat($this->order_final_amount) . ' تومان' ?? 0;
    }

    /**
     * @return int|string
     */
    public function orderDiscountAmountFaPrice(): int|string
    {
        return priceFormat($this->order_discount_amount) . ' تومان' ?? 0;
    }

    /**
     * @return int|string
     */
    public function orderTotalProductsDiscountAmountFaPrice(): int|string
    {
        return priceFormat($this->order_total_products_discount_amount) . ' تومان' ?? 0;
    }

    /**
     * @return int|string
     */
    public function orderFinalFaPrice(): int|string
    {
        return priceFormat($this->order_final_amount -  $this->order_discount_amount) . ' تومان' ?? 0;
    }

    /**
     * @return int|string
     */
    public function orderDeliveryAmountFaPrice(): int|string
    {
        return priceFormat($this->delivery_amount) . ' تومان' ?? 0;
    }

    /**
     * @return int|string
     */
    public function orderCopanDiscountAmountFaPrice(): int|string
    {
        return priceFormat($this->order_copan_discount_amount) . ' تومان'
            ?? convertEnglishToPersian(0);
    }

    /**
     * @return int|string
     */
    public function orderCommonDiscountAmountFaPrice(): int|string
    {
        return priceFormat($this->order_common_discount_amount) . ' تومان' ?? 0;
    }

    /**
     * @return string
     */
    public function paymentGateway(): string
    {
        return $this->payment->paymentable->gateway ?? '-';
    }

    /**
     * @return string
     */
    public function deliveryMethodName(): string
    {
        return $this->delivery->name ?? '-';
    }

    /**
     * @return string
     */
    public function customerName(): string
    {
        return $this->user->fullName ?? $this->user->first_name ?? '-';
    }

    /**
     * @return string
     */
    public function textCustomerAddress(): string
    {
        return $this->address->address ?? 'آدرس مشتری یافت نشد.';
    }

    /**
     * @return string
     */
    public function textCustomerCity(): string
    {
        return $this->address->city->name ?? 'آدرس مشتری یافت نشد.';
    }

    /**
     * @return array|string
     */
    public function customerPostalCode(): array|string
    {
        return convertEnglishToPersian($this->address->postal_code) ?? 'کد پستی یافت نشد.';
    }

    /**
     * @return array|string
     */
    public function customerUnit(): array|string
    {
        return convertEnglishToPersian($this->address->unit) ?? 'واحد یافت نشد.';
    }

    /**
     * @return array|string
     */
    public function customerNo(): array|string
    {
        return convertEnglishToPersian($this->address->no) ?? 'شماره پلاک یافت نشد.';
    }

    /**
     * @return string
     */
    public function recipientFName(): string
    {
        return $this->address->recipient_first_name ?? 'نام گیرنده کالا یافت نشد.';
    }

    /**
     * @return string
     */
    public function recipientLName(): string
    {
        return $this->address->recipient_last_name ?? 'نام گیرنده کالا یافت نشد.';
    }

    /**
     * @return array|string
     */
    public function customerFaMobile(): array|string
    {
        return convertEnglishToPersian($this->address->mobile) ?? 'شماره موبایل یافت نشد.';
    }

    /**
     * @return string
     */
    public function orderSendDate(): string
    {
        return jalaliDate($this->delivery_time) ?? 'تاریخ ارسال یافت نشد.';
    }


    /**
     * @return string
     */
    public function customerUsedCopan(): string
    {
        return $this->copan->code ?? 'کوپن تخفیف ندارد.';
    }

    public function usedCommonDiscountTitle()
    {
        return $this->commonDiscount->title ?? 'عنوان تخفیف عمومی یافت نشد.';
    }
}

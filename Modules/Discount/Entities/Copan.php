<?php

namespace Modules\Discount\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Share\Traits\HasFaDate;
use Modules\User\Entities\User;

class Copan extends Model
{
    use HasFactory;

    use HasFactory, SoftDeletes, HasFaDate;

    public const STATUS_ACTIVE = 1;

    public const STATUS_INACTIVE = 0;

    public const AMOUNT_TYPE_PERCENTAGE = 0;
    public const AMOUNT_TYPE_PRICE = 1;
    public const COPAN_TYPE_PUBLIC = 0;
    public const COPAN_TYPE_PRIVATE = 1;

    /**
     * @var array|int[]
     */
    public static array $statuses = [self::STATUS_ACTIVE, self::STATUS_INACTIVE];

    /**
     * @var string[]
     */
    protected $fillable = ['code', 'amount', 'amount_type' , 'discount_ceiling' , 'type' , 'user_id' ,'start_date', 'end_date', 'status'];

    // Relations

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Methods

    /**
     * @return string
     */
    public function getFaAmount(): string
    {
        return $this->amount_type == self::AMOUNT_TYPE_PERCENTAGE ? ' % ' . convertEnglishToPersian($this->amount)
            : priceFormat($this->amount) . ' تومان';
    }

    /**
     * @return string
     */
    public function textAmountType(): string
    {
        return $this->amount_type == self::AMOUNT_TYPE_PERCENTAGE ? 'درصدی' : 'عددی';
    }

    /**
     * @return string
     */
    public function getFaDiscountCeiling(): string
    {
        return priceFormat($this->discount_ceiling) . ' تومان ' ?? $this->discount_ceiling . ' تومان ' ?? '-';
    }

    /**
     * @return string
     */
    public function textDiscountType(): string
    {
        return $this->type == self::COPAN_TYPE_PUBLIC ? 'عمومی' : 'خصوصی';
    }

    /**
     * @return mixed|string
     */
    public function getFaStartDate(): mixed
    {
        return jalaliDate($this->start_date) ?? $this->start_date;
    }

    /**
     * @return mixed|string
     */
    public function getFaEndDate(): mixed
    {
        return jalaliDate($this->end_date) ?? $this->end_date;
    }

    /**
     * @return string
     */
    public function getUserAssignedCopan(): string
    {
        return $this->user->fullName ?? '-';
    }
}

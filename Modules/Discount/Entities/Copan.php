<?php

namespace Modules\Discount\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Share\Traits\HasDefaultStatus;
use Modules\Share\Traits\HasFaDate;
use Modules\Share\Traits\HasFaPropertiesTrait;
use Modules\User\Entities\User;

class Copan extends Model
{
    use HasFactory;

    use HasFactory, SoftDeletes, HasFaDate, HasDefaultStatus;

    public const AMOUNT_TYPE_PERCENTAGE = 0;
    public const AMOUNT_TYPE_PRICE = 1;
    public const COPAN_TYPE_PUBLIC = 0;
    public const COPAN_TYPE_PRIVATE = 1;

    /**
     * @var string[]
     */
    protected $fillable = ['code', 'amount', 'amount_type' , 'discount_ceiling' , 'type' , 'user_id' ,'start_date', 'end_date', 'status'];

    // ********************************************* Relations

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // ********************************************* Methods

    /**
     * @return string
     */
    public function getNameOfUserAssignedCopan(): string
    {
        return $this->user->fullName ?? '-';
    }

    // ********************************************* paths

    // ********************************************* FA Properties

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
    public function getAmountType(): string
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
    public function getDiscountType(): string
    {
        return $this->type == self::COPAN_TYPE_PUBLIC ? 'عمومی' : 'خصوصی';
    }

}

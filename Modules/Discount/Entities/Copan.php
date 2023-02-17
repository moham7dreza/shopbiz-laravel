<?php

namespace Modules\Discount\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;
use Modules\Discount\Traits\CopanHasTypesTrait;
use Modules\Share\Traits\HasDefaultStatus;
use Modules\Share\Traits\HasFaDate;

use Modules\User\Entities\User;

class Copan extends Model
{
    use HasFactory;

    use HasFactory, SoftDeletes, HasFaDate, HasDefaultStatus, CopanHasTypesTrait;

    /**
     * @var string[]
     */
    protected $fillable = ['code', 'amount', 'amount_type', 'discount_ceiling', 'type', 'user_id', 'start_date', 'end_date', 'status'];

    // ********************************* scope

    /**
     * @param $query
     * @return mixed
     */
    public function scopeAlreadyActive($query): mixed
    {
        return $query->where([
            ['start_date', '<', Carbon::now()],
            ['end_date', '>', Carbon::now()],
            ['status', $this->statusActive()]
        ]);
    }

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

    /**
     * @return bool
     */
    public function activated(): bool
    {
        return $this->start_date < Carbon::now() && $this->end_date > Carbon::now() && $this->status == $this->statusActive();
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
    public function getFaAmountType(): string
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

<?php

namespace Modules\Discount\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Modules\Share\Traits\HasDefaultStatus;
use Modules\Share\Traits\HasFaDate;

class CommonDiscount extends Model
{
    /**
     * @var string
     */
    protected $table = 'common_discount';

    use HasFactory, SoftDeletes, HasFaDate, HasDefaultStatus;

    /**
     * @var string[]
     */
    protected $fillable = ['title', 'percentage', 'discount_ceiling', 'minimal_order_amount', 'start_date', 'end_date', 'status'];

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

    // ********************************************* Methods

    /**
     * @param int $size
     * @return string
     */
    public function getLimitedTitle(int $size = 50): string
    {
        return Str::limit($this->title, $size) ?? '-';
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
    public function getFaPercentage(): string
    {
        return '%' . convertEnglishToPersian($this->percentage) ?? $this->percentage . ' %';
    }

    /**
     * @return string
     */
    public function getFaDiscountCeiling(): string
    {
        return priceFormat($this->discount_ceiling) . ' تومان ' ?? $this->discount_ceiling . ' تومان ';
    }

    /**
     * @return string
     */
    public function getFaMinimalOrderAmountPrice(): string
    {
        return priceFormat($this->minimal_order_amount) . ' تومان ' ?? $this->minimal_order_amount . ' تومان ';
    }
}

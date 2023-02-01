<?php

namespace Modules\Discount\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
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
    public function limitedTitle(): string
    {
        return Str::limit($this->title, 50);
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
    public function minimalOrderAmountFaPrice(): string
    {
        return priceFormat($this->minimal_order_amount) . ' تومان ' ?? $this->minimal_order_amount . ' تومان ';
    }
}

<?php

namespace Modules\Discount\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Product\Entities\Product;
use Modules\Share\Traits\HasFaDate;

class AmazingSale extends Model
{
    use HasFactory, SoftDeletes, HasFaDate;

    public const STATUS_ACTIVE = 1;
    public const STATUS_INACTIVE = 0;

    /**
     * @var array|int[]
     */
    public static array $statuses = [self::STATUS_ACTIVE, self::STATUS_INACTIVE];

    /**
     * @var string[]
     */
    protected $fillable = ['product_id', 'percentage', 'start_date', 'end_date', 'status'];

    /**
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    // Methods

    /**
     * @return string
     */
    public function textProductName(): string
    {
        return $this->product->name ?? 'نام کالا یافت نشد.';
    }

    /**
     * @return string
     */
    public function getFaPercentage(): string
    {
        return convertEnglishToPersian($this->percentage) . ' %' ?? $this->percentage . ' %';
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
}

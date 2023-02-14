<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Modules\Share\Traits\HasDefaultStatus;
use Modules\Share\Traits\HasFaDate;
use Modules\Share\Traits\HasFaPropertiesTrait;

class Guarantee extends Model
{
    use HasFactory, SoftDeletes, HasFaDate, HasDefaultStatus;

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'product_id',
        'price_increase',
        'status',
        'duration'
    ];

    // ********************************************* Relations

    /**
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    // ********************************************* Methods

    /**
     * @param int $size
     * @return string
     */
    public function getProductName(int $size = 100): string
    {
        return Str::limit($this->product->name, $size) ?? '-';
    }

    // ********************************************* FA Properties

    /**
     * @return string
     */
    public function getFaPriceIncrease(): string
    {
        return priceFormat($this->price_increase) . ' تومان ';
    }

    /**
     * @return string
     */
    public function getFaDurationTime(): string
    {
        return convertEnglishToPersian($this->duration) . ' ماهه ';
    }

    /**
     * @return string
     */
    public function getFaFullName(): string
    {
        return $this->name . ' - ' . $this->getFaDurationTime();
    }
}

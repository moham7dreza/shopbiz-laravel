<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class ProductColor extends Model
{

    public const STATUS_ACTIVE = 1;
    public const STATUS_INACTIVE = 0;

    /**
     * @var array|int[]
     */
    public static array $statuses = [self::STATUS_ACTIVE, self::STATUS_INACTIVE];

    use HasFactory, SoftDeletes;

    /**
     * @var string[]
     */
    protected $fillable = ['color_name', 'color' , 'product_id', 'price_increase', 'status', 'sold_number', 'frozen_number', 'marketable_number'];

    /**
     * @var string[]
     */
    protected $casts = ['image' => 'array'];


    /**
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

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
    public function textProductName(): string
    {
        return Str::limit($this->product->name) ?? '-';
    }

    /**
     * @return int|string
     */
    public function getFaMarketableNumber(): int|string
    {
        return convertEnglishToPersian($this->marketable_number) . ' عدد' ?? 0;
    }

    /**
     * @return int|string
     */
    public function getFaSoldNumber(): int|string
    {
        return convertEnglishToPersian($this->sold_number) . ' عدد' ?? 0;
    }

    /**
     * @return int|string
     */
    public function getFaFrozenNumber(): int|string
    {
        return convertEnglishToPersian($this->frozen_number) . ' عدد' ?? 0;
    }
}

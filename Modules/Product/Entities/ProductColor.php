<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use Modules\Share\Traits\HasDefaultStatus;


class ProductColor extends Model
{
    use HasFactory, SoftDeletes, HasDefaultStatus;

    /**
     * @var string[]
     */
    protected $fillable = ['product_id', 'color_id', 'price_increase', 'status', 'sold_number', 'frozen_number', 'marketable_number'];

    /**
     * @var string
     */
    protected $table = 'product_color';

    // ********************************************* relations

    /**
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * @return BelongsTo
     */
    public function color(): BelongsTo
    {
        return $this->belongsTo(Color::class);
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

    /**
     * @return mixed
     */
    public function getColorCode(): mixed
    {
        return $this->color->code;
    }

    public function getColorName()
    {
        return $this->color->name;
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

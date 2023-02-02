<?php

namespace Modules\Discount\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use Modules\Discount\Repositories\AmazingSale\AmazingSaleDiscountRepoEloquent;
use Modules\Discount\Repositories\AmazingSale\AmazingSaleDiscountRepoEloquentInterface;
use Modules\Product\Entities\Product;
use Modules\Share\Traits\HasDefaultStatus;
use Modules\Share\Traits\HasFaDate;
use Modules\Share\Traits\HasFaPropertiesTrait;
use Modules\Share\Traits\HasImageTrait;

class AmazingSale extends Model
{
    use HasFactory, SoftDeletes, HasFaDate, HasDefaultStatus, HasFaPropertiesTrait, HasImageTrait;

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
     * @return array|int|string|string[]
     */
    public function productFinalFaPrice(): array|int|string
    {
        $productPrice = $this->product->price + ($this->product->colors[0]->price_increase ?? 0) +
                ($this->product->guarantees[0]->price_increase ?? 0);
        $productDiscount = $this->product->price * $this->percentage / 100;
        return priceFormat($productPrice - $productDiscount) ?? 0 . ' تومان';
    }

    /**
     * @return Model|HasMany|null
     */
    public static function activeAmazingSales(): Model|HasMany|null
    {
        $amazingSaleDiscountRepo = new AmazingSaleDiscountRepoEloquent();
        return $amazingSaleDiscountRepo->activeAmazingSales()->first();
    }
}

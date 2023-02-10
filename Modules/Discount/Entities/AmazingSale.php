<?php

namespace Modules\Discount\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Modules\Discount\Repositories\AmazingSale\AmazingSaleDiscountRepoEloquent;
use Modules\Discount\Repositories\AmazingSale\AmazingSaleDiscountRepoEloquentInterface;
use Modules\Product\Entities\Product;
use Modules\Share\Traits\HasDefaultStatus;
use Modules\Share\Traits\HasFaDate;
use Modules\Share\Traits\HasFaPropertiesTrait;
use Modules\Share\Traits\HasImageTrait;
use function Assert\that;

class AmazingSale extends Model
{
    use HasFactory, SoftDeletes, HasFaDate, HasDefaultStatus;

    /**
     * @var string[]
     */
    protected $fillable = ['product_id', 'percentage', 'start_date', 'end_date', 'status'];

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
            ['status', AmazingSale::STATUS_ACTIVE]
        ]);
    }

    // ********************************************* Relations

    /**
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    // ********************************************* Methods

    /**
     * @return string
     */
    public function getProductName(): string
    {
        return $this->product->name ?? '-';
    }

    /**
     * @return Model|HasMany|null
     */
    public static function activeAmazingSales(): Model|HasMany|null
    {
        $amazingSaleDiscountRepo = new AmazingSaleDiscountRepoEloquent();
        return $amazingSaleDiscountRepo->activeAmazingSales()->first();
    }

    /**
     * @return bool
     */
    public function activated(): bool
    {
        return $this->start_date < Carbon::now() && $this->end_date > Carbon::now() && $this->status == AmazingSale::STATUS_ACTIVE;
    }

    // ********************************************* FA Properties

    /**
     * @return string
     */
    public function getFaPercentage(): string
    {
        return ' % ' . convertEnglishToPersian($this->percentage) ?? $this->percentage . ' %';
    }

    // ********************************************* product

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
     * @return string
     */
    public function productImagePath(): string
    {
        return asset($this->product->image['indexArray']['medium']);
    }

    /**
     * @return mixed
     */
    public function productFaPrice(): mixed
    {
        return $this->product->getFaprice();
    }
}

<?php

namespace Modules\Product\Entities;

use Cviebrock\EloquentSluggable\Sluggable;
use CyrildeWit\EloquentViewable\Contracts\Viewable;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Modules\Attribute\Entities\AttributeValue;
use Modules\Brand\Entities\Brand;
use Modules\Category\Entities\ProductCategory;
use Modules\Discount\Entities\AmazingSale;
use Modules\Discount\Repositories\AmazingSale\AmazingSaleDiscountRepoEloquent;
use Modules\Share\Traits\HasComment;
use Modules\Share\Traits\HasDefaultStatus;
use Modules\Share\Traits\HasFaDate;
use Overtrue\LaravelFavorite\Traits\Favoriteable;
use Overtrue\LaravelLike\Traits\Likeable;
use Spatie\Tags\HasTags;

class Product extends Model implements Viewable
{
    use HasFactory, SoftDeletes, Sluggable, HasTags,
        HasFaDate, HasComment, HasDefaultStatus,
        InteractsWithViews, Likeable, Favoriteable;

    public const POPULAR = 1;
    public const NOT_POPULAR = 0;
    public const SELECTED = 1;
    public const NOT_SELECTED = 0;
    public const MARKETABLE = 1;
    public const NOT_MARKETABLE = 0;

//    # Booted
//    /**
//     * Boot product model.
//     */
//    public static function boot()
//    {
//        parent::boot();
//
//        static::deleting(static function($product) {
//            $product->categories()->delete();
//            $product->tags()->delete();
//            $product->galleries()->delet();
//            $product->attributes()->deleteAllAttribute();
//        });
//    }



    /**
     * @return array[]
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    /**
     * @var string[]
     */
    protected $casts = ['image' => 'array'];

    /**
     * @var string[]
     */
    protected $fillable = [
        'name', 'introduction', 'slug', 'image', 'status', 'weight', 'length', 'width',
        'height', 'price', 'marketable', 'sold_number', 'frozen_number', 'marketable_number', 'brand_id',
        'category_id', 'published_at'
    ];

    // ********************************************* scope
    /**
     * Scope product popular.
     *
     * @param  $query
     * @return mixed
     */
    public function scopePopular($query): mixed
    {
        return $query->where('popular', self::POPULAR);
    }

    /**
     * @param $query
     * @param int $selected
     * @return mixed
     */
    public function scopeSelected($query, int $selected = self::SELECTED): mixed
    {
        return $query->where('selected', $selected);
    }

    /**
     * @param $query
     * @param int $marketable
     * @return mixed
     */
    public function scopeMarketable($query, int $marketable = self::MARKETABLE): mixed
    {
        return $query->where('marketable', $marketable);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeReadyForSale($query): mixed
    {
        return $query->where([
            ['status', self::STATUS_ACTIVE],
            ['marketable', self::MARKETABLE],
            ['marketable_number', '>', 0],
            ['published_at', '<', now()]
        ]);
    }

    /**
     * @param $query
     * @param int $count
     * @return mixed
     */
    public function scopeLowMarketableNumber($query, int $count = 10): mixed
    {
        return $query->where('marketable_number', '<', $count);
    }

    /**
     * @param $query
     * @param int $count
     * @return mixed
     */
    public function scopeLowViewNumber($query, int $count = 10): mixed
    {
        return $query->where('views_count', '<', $count);
    }

    // ********************************************* Relations

    /**
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    /**
     * @return BelongsTo
     */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    /**
     * @return HasMany
     */
    public function metas(): HasMany
    {
        return $this->hasMany(ProductMeta::class);
    }

    /**
     * @return HasMany
     */
    public function colors(): HasMany
    {
        return $this->hasMany(ProductColor::class);
    }

    /**
     * @return HasMany
     */
    public function images(): HasMany
    {
        return $this->hasMany(Gallery::class);
    }

    /**
     * @return HasMany
     */
    public function guarantees(): HasMany
    {
        return $this->hasMany(ProductGuarantee::class);
    }

    /**
     * @return HasMany
     */
    public function amazingSales(): HasMany
    {
        return $this->hasMany(AmazingSale::class);
    }

    /**
     * @return HasMany
     */
    public function values(): HasMany
    {
        return $this->hasMany(AttributeValue::class);
    }

    /**
     * Relation to product_rates table, one to many.
     *
     * @return MorphMany
     */
    public function reviews(): MorphMany
    {
        return $this->morphMany('Modules\Share\Entities\Review', 'reviewable');
    }

    // methods

    /**
     * @return Model|HasMany|null
     */
    public function activeAmazingSales(): Model|HasMany|null
    {
        $amazingSaleDiscountRepo = new AmazingSaleDiscountRepoEloquent();
        return $amazingSaleDiscountRepo->activeAmazingSales($this->id)->first();
    }

    // ********************************************* Methods

    /**
     * @param int $size
     * @return string
     */
    public function getLimitedName(int $size = 50): string
    {
        return Str::limit($this->name, $size) ?? '-';
    }

    /**
     * @param int $size
     * @return string
     */
    public function getLimitedIntroduction(int $size = 50): string
    {
        return strip_tags(Str::limit($this->introduction, $size)) ?? '-';
    }

    /**
     * @return string
     */
    public function getCategoryName(): string
    {
        return $this->category->name ?? 'دسته ندارد';
    }

    /**
     * @return mixed|string
     */
    public function getTagLessIntroduction(): mixed
    {
        return strip_tags($this->introduction) ?? $this->introduction ?? '-';
    }

    /**
     * Get rate score.
     *
     * @return float|int
     */
    public function calculateRate(): float|int
    {
        $totalRate = $this->reviews()->get()->sum('rate');
        $totalRateCount = $this->reviews()->count();
        $calculateRate = (int)$totalRate / $totalRateCount;
        $calculateRate *= getAdditionalRateNumber($this->like_count);
        $calculateRate *= getAdditionalRateNumber($this->view_count);
        $calculateRate *= getAdditionalRateNumber($this->comment_count);
        if ($calculateRate >= 5) {
            return 5;
        }
        return round((int)$calculateRate);
    }

    /**
     * @return bool
     */
    public function popular(): bool
    {
        return $this->popular == self::POPULAR;
    }

    /**
     * @return bool
     */
    public function selected(): bool
    {
        return $this->selected == self::SELECTED;
    }

    // ********************************************* paths

    /**
     * @return string
     */
    public function path(): string
    {
        return route('customer.market.product', $this->slug) ?? '#';
    }

    /**
     * @return mixed
     */
    public function getCategoryPath(): mixed
    {
        return $this->category->path();
    }

    /**
     * @param string $size
     * @return string
     */
    public function imagePath(string $size = 'medium'): string
    {
        return asset($this->image['indexArray'][$size]);
    }

    // ********************************************* FA Properties

    /**
     * @return int|string
     */
    public function getFaWeight(): int|string
    {
        return convertEnglishToPersian($this->weight) . ' کیلو' ?? 0;
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

    /**
     * @return array|int|string
     */
    public function getFaAmazingSalesPercentage(): array|int|string
    {
        return '% ' . convertEnglishToPersian($this->activeAmazingSales()->percentage) ?? 0;
    }

    /**
     * @return string
     */
    public function getFaPrice(): string
    {
        return priceFormat($this->price) . ' تومان ';
    }

    /**
     * @return string
     */
    public function getFaPriceRead(): string
    {
        return generateReadingPrice((int)$this->price) . ' تومان ';
    }

    /**
     * @return array|string|string[]
     */
    public function getFaFinalPrice(): array|string
    {
        $productPrice = $this->price + ($this->colors[0]->price_increase ?? 0) +
            ($this->guarantees[0]->price_increase ?? 0);
        $productDiscount = $this->price * $this->activeAmazingSales()->percentage / 100;
        return (priceFormat($productPrice - $productDiscount) ?? 0) . ' تومان';
    }

    /**
     * @return array|string|string[]
     */
    public function getFaProductDiscountPrice(): array|string
    {
        $productDiscount = $this->price * $this->activeAmazingSales()->percentage / 100;
        return (priceFormat($productDiscount) ?? 0) . ' تومان';
    }

    /**
     * @return string
     */
    public function getFaActualPrice(): string
    {
        $productPrice = $this->price + ($this->colors[0]->price_increase ?? 0) +
            ($this->guarantees[0]->price_increase ?? 0);
        return priceFormat($productPrice) . ' تومان';
    }

    /**
     * @return array|int|string
     */
    public function getFaProductRating(): array|int|string
    {
        return convertEnglishToPersian($this->rating) ?? 0;
    }

    // ********************************************* FA counters

    /**
     * @return array|int|string
     */
    public function getFaViewsCount(): array|int|string
    {
        return convertEnglishToPersian(views($this)->unique()->count()) ?? 0;
    }

    /**
     * @return array|int|string
     */
    public function getFaLikersCount(): array|int|string
    {
        return convertEnglishToPersian($this->likers()->count()) ?? 0;
    }
}

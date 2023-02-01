<?php

namespace Modules\Product\Entities;

use Cviebrock\EloquentSluggable\Sluggable;
use CyrildeWit\EloquentViewable\Contracts\Viewable;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Modules\Attribute\Entities\AttributeValue;
use Modules\Brand\Entities\Brand;
use Modules\Category\Entities\ProductCategory;
use Modules\Discount\Entities\AmazingSale;
use Modules\Discount\Repositories\AmazingSale\AmazingSaleDiscountRepoEloquent;
use Modules\Discount\Repositories\AmazingSale\AmazingSaleDiscountRepoEloquentInterface;
use Modules\Share\Traits\HasComment;
use Modules\Share\Traits\HasCountersTrait;
use Modules\Share\Traits\HasDefaultStatus;
use Modules\Share\Traits\HasFaDate;
use Overtrue\LaravelFavorite\Traits\Favoriteable;
use Overtrue\LaravelLike\Traits\Likeable;
use Spatie\Tags\HasTags;

class Product extends Model implements Viewable
{
    use HasFactory, SoftDeletes, Sluggable, HasTags,
        HasFaDate, HasComment, HasDefaultStatus, HasCountersTrait,
        InteractsWithViews, Likeable, Favoriteable;

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
    # Scopes
    /**
     * Scope product popular.
     *
     * @param  $query
     * @return mixed
     */
    public function scopePopular($query): mixed
    {
        return $query->where('is_popular', 1);
    }


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
        'name', 'introduction', 'slug', 'image', 'status', 'tags', 'weight', 'length', 'width',
        'height', 'price', 'marketable', 'sold_number', 'frozen_number', 'marketable_number', 'brand_id',
        'category_id', 'published_at'
    ];

    // relations

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
        return $this->hasMany(Guarantee::class);
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
     * @return BelongsToMany
     */
    public function rates(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'product_rates');
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

    // paths

    /**
     * @return string
     */
    public function path(): string
    {
        return route('customer.market.product', $this->slug) ?? '#';
    }

    /**
     * @param string $size
     * @return string
     */
    public function imagePath(string $size = 'medium'): string
    {
        return asset($this->image['indexArray'][$size]);
    }

    /**
     * @return mixed
     */
    public function categoryPath(): mixed
    {
        return $this->category->path();
    }

    // text property

    /**
     * @return int|string
     */
    public function getFaWeight(): int|string
    {
        return convertEnglishToPersian($this->weight) . ' کیلو' ?? 0;
    }

    /**
     * @return string
     */
    public function limitedName(): string
    {
        return Str::limit($this->name, 50) ?? '-';
    }

    /**
     * @return string
     */
    public function textCategoryName(): string
    {
        return $this->category->name ?? 'دسته ندارد';
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
     * @return mixed|string
     */
    public function tagLessIntro(): mixed
    {
        return strip_tags($this->introduction) ?? $this->introduction ?? '-';
    }

    /**
     * @return array|int|string
     */
    public function getFaAmazingSalesPercentage(): array|int|string
    {
        return '% ' . convertEnglishToPersian($this->activeAmazingSales()->percentage) ?? 0;
    }


    // price calc

    /**
     * @return string
     */
    public function getFaPrice(): string
    {
        return priceFormat($this->price) . ' تومان ';
    }

    /**
     * @return array|string|string[]
     */
    public function getFinalFaPrice(): array|string
    {
        $productPrice = $this->price + ($this->colors[0]->price_increase ?? 0) +
            ($this->guarantees[0]->price_increase ?? 0);
        $productDiscount = $this->price * $this->activeAmazingSales()->percentage / 100;
        return (priceFormat($productPrice - $productDiscount) ?? 0) . ' تومان';
    }

    /**
     * @return string
     */
    public function getActualFaPrice(): string
    {
        $productPrice = $this->price + ($this->colors[0]->price_increase ?? 0) +
            ($this->guarantees[0]->price_increase ?? 0);
        return convertEnglishToPersian($productPrice) . ' تومان';
    }

    /**
     * Get rate score.
     *
     * @return int
     */
    public function getRate(): int
    {
        $totalRate      = $this->rates()->get()->sum('rates');
        $totalRateCount = $this->rates()->count();
        $calculateRate  = (int) $totalRate / $totalRateCount;

        return (int) round((int) $calculateRate);
    }
}

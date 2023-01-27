<?php

namespace Modules\Product\Entities;

use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Modules\Brand\Entities\Brand;
use Modules\Category\Entities\CategoryValue;
use Modules\Category\Entities\ProductCategory;
use Modules\Discount\Entities\AmazingSale;
use Modules\Share\Traits\HasComment;
use Modules\Share\Traits\HasFaDate;
use Modules\User\Entities\User;

class Product extends Model
{
    use HasFactory, SoftDeletes, Sluggable, HasFaDate, HasComment;

    public const STATUS_ACTIVE = 1;
    public const STATUS_INACTIVE = 0;

    /**
     * @var array|int[]
     */
    public static array $statuses = [self::STATUS_ACTIVE, self::STATUS_INACTIVE];

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
    protected $fillable = ['name', 'introduction', 'slug', 'image', 'status', 'tags', 'weight', 'length', 'width',
        'height', 'price', 'marketable', 'sold_number', 'frozen_number', 'marketable_number', 'brand_id',
        'category_id', 'published_at'];

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
     * @return BelongsToMany
     */
    public function user(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
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
        return $this->hasMany(CategoryValue::class);
    }

    // methods

    /**
     * @return Model|HasMany|null
     */
    public function activeAmazingSales(): Model|HasMany|null
    {
        return $this->amazingSales()->where([
            ['start_date', '<', Carbon::now()],
            ['end_date', '>', Carbon::now()],
            ['status', AmazingSale::STATUS_ACTIVE]
        ])->first();
    }

    /**
     * @return string
     */
    public function path(): string
    {
        return route('customer.market.product', $this->slug) ?? '#';
    }

    /**
     * @return string
     */
    public function getFaPrice(): string
    {
        return priceFormat($this->price) . ' تومان ';
    }

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
     * @param string $size
     * @return string
     */
    public function imagePath(string $size = 'medium'): string
    {
        return asset($this->image['indexArray'][$size]);
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
}

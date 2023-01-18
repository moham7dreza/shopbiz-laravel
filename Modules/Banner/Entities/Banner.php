<?php

namespace Modules\Banner\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Modules\Share\Traits\HasFaDate;

class Banner extends Model
{
    use HasFactory, SoftDeletes, HasFaDate;

    public const STATUS_ACTIVE = 1;
    public const STATUS_INACTIVE = 0;

    public const POSITION_SLIDE_SHOW = 0;
    public const POSITION_INSIDE_SLIDE_SHOW = 1;
    public const POSITION_2_MIDDLE_BANNERS = 2;
    public const POSITION_2_BOTTOM_BANNERS = 3;
    public const POSITION_BIG_BOTTOM_BANNER = 4;
    public const POSITION_BIG_BRANDS_BANNER = 5;
    public const POSITION_4_MIDDLE_BANNERS = 6;

    public static array $bannerPositions = [
        self::POSITION_SLIDE_SHOW
        , self::POSITION_INSIDE_SLIDE_SHOW
        , self::POSITION_2_MIDDLE_BANNERS
        , self::POSITION_2_BOTTOM_BANNERS
        , self::POSITION_BIG_BOTTOM_BANNER
        , self::POSITION_BIG_BRANDS_BANNER
        , self::POSITION_4_MIDDLE_BANNERS
    ];

    /**
     * @var array|int[]
     */
    public static array $statuses = [self::STATUS_ACTIVE, self::STATUS_INACTIVE];

    /**
     * @var string[]
     */
    protected $casts = ['image' => 'array'];

    /**
     * @var string[]
     */
    protected $fillable = [
        'title',
        'image',
        'url',
        'position',
        'status'
    ];

    /**
     * @var array|string[]
     */
    public static array $positions = [
        self::POSITION_SLIDE_SHOW => 'اسلاید شو (صفحه اصلی)',
        self::POSITION_INSIDE_SLIDE_SHOW => 'کنار اسلاید شو (صفحه اصلی)',
        self::POSITION_2_MIDDLE_BANNERS => 'دو بنر تبلیغی بین دو اسلایدر  (صفحه اصلی)',
        self::POSITION_2_BOTTOM_BANNERS => 'دو بنر تبلیغی بین دو اسلایدر پایینی  (صفحه اصلی)',
        self::POSITION_BIG_BOTTOM_BANNER => 'بنر تبلیغی بزرگ پایین دو اسلایدر  (صفحه اصلی)',
        self::POSITION_BIG_BRANDS_BANNER => 'بنر تبلیغی برندها در اتمام صفحه  (صفحه اصلی)',
        self::POSITION_4_MIDDLE_BANNERS => 'چهار بنر تبلیغی در میان صفحه  (صفحه اصلی)',
    ];

    // Methods

    /**
     * @return string
     */
    public function imagePath(): string
    {
        return asset($this->image);
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
    public function cssStatus(): string
    {
        if ($this->status === self::STATUS_ACTIVE) return 'success';
        else if ($this->status === self::STATUS_INACTIVE) return 'danger';
        else return 'warning';
    }

    /**
     * @return string
     */
    public function textStatus(): string
    {
        return $this->status === self::STATUS_ACTIVE ? 'فعال' : 'غیر فعال';
    }

    /**
     * @return mixed|string
     */
    public function textPosition(): mixed
    {
        return self::$positions[$this->position] ?? 'مکان بنر مشخص نیست.';
    }
}

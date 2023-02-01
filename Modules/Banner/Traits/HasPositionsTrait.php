<?php

namespace Modules\Banner\Traits;

trait HasPositionsTrait
{
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
}

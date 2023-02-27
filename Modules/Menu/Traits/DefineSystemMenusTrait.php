<?php

namespace Modules\Menu\Traits;

trait DefineSystemMenusTrait
{
    public const prefix = '/pages';
    public const MENU_SPECIAL_SALE = [
        'name' => 'فروش ویژه',
        'url' => '/products/special-sale',
        'status' => self::STATUS_ACTIVE
    ];
    public const MENU_WARRANTY_RULES = ['name' => 'شرایط گارانتی', 'url' => self::prefix . '/warranty-rules', 'status' => self::STATUS_ACTIVE];
    public const MENU_ABOUT_US = ['name' => 'درباره ما', 'url' => self::prefix . '/about-us', 'status' => self::STATUS_ACTIVE];
    public const MENU_CONTACT_US = ['name' => 'تماس با ما', 'url' => self::prefix . '/contact-us', 'status' => self::STATUS_ACTIVE];
    public const MENU_PRIVACY_POLICY = ['name' => 'شرایط و قوانین ما', 'url' => self::prefix . '/privacy-policy', 'status' => self::STATUS_ACTIVE];
    public const MENU_MAKE_APPOINTMENT = ['name' => 'ثبت قرار ملاقات', 'url' => self::prefix . '/make-appointment', 'status' => self::STATUS_ACTIVE];
    public const MENU_INSTALLMENT = ['name' => 'خرید اقساطی', 'url' => self::prefix . '/installment', 'status' => self::STATUS_ACTIVE];
    public const MENU_CAREER = ['name' => 'سابقه شغلی', 'url' => self::prefix . '/career', 'status' => self::STATUS_ACTIVE];
    public const MENU_HOW_TO_BUY = ['name' => 'راهنمای خرید', 'url' => self::prefix . '/how-to-buy', 'status' => self::STATUS_ACTIVE];
    public const MENU_PRICE_PLANS = ['name' => 'پلن های قیمت گذاری ما', 'url' => self::prefix . '/price-plans', 'status' => self::STATUS_ACTIVE];
    public const MENU_WHY_THIS_SHOP = ['name' => 'چرا شاپ بیز', 'url' => self::prefix . '/why-this-shop', 'status' => self::STATUS_ACTIVE];
    public const MENU_FAQ = ['name' => 'سوالات متداول', 'url' => self::prefix . '/faq', 'status' => self::STATUS_ACTIVE];

    /**
     * @var array
     */
    public static array $menus = [
        self::MENU_SPECIAL_SALE,
        self::MENU_CAREER,
        self::MENU_WARRANTY_RULES,
        self::MENU_ABOUT_US,
        self::MENU_CONTACT_US,
        self::MENU_PRIVACY_POLICY,
        self::MENU_INSTALLMENT,
        self::MENU_MAKE_APPOINTMENT,
        self::MENU_HOW_TO_BUY,
        self::MENU_PRICE_PLANS,
        self::MENU_WHY_THIS_SHOP,
        self::MENU_FAQ,
    ];
}

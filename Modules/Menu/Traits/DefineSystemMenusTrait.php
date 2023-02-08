<?php

namespace Modules\Menu\Traits;

trait DefineSystemMenusTrait
{
    public const MENU_SPECIAL_SALE = ['name' => 'فروش ویژه', 'url' => '/products/special-sale', 'status' => self::STATUS_ACTIVE];
    public const MENU_GUARANTEE = ['name' => 'گارانتی', 'url' => '/', 'status' => self::STATUS_ACTIVE];

    /**
     * @var array
     */
    public static array $menus = [self::MENU_SPECIAL_SALE, self::MENU_GUARANTEE];
}

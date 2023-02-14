<?php

namespace Modules\Discount\Traits;

trait CopanHasTypesTrait
{
    public const AMOUNT_TYPE_PERCENTAGE = 0;
    public const AMOUNT_TYPE_PRICE = 1;
    public const COPAN_TYPE_PUBLIC = 0;
    public const COPAN_TYPE_PRIVATE = 1;

    /**
     * @var array|int[]
     */
    public static array $copanTypes = [self::COPAN_TYPE_PUBLIC, self::COPAN_TYPE_PRIVATE];

    /**
     * @var array|int[]
     */
    public static array $amountTypes = [self::AMOUNT_TYPE_PERCENTAGE, self::AMOUNT_TYPE_PRICE];

    /**
     * @var array|string[]
     */
    public static array $copanTypesWithValues = [
        self::COPAN_TYPE_PUBLIC => 'عمومی',
        self::COPAN_TYPE_PRIVATE => 'خصوصی'
    ];

    /**
     * @var array|string[]
     */
    public static array $amountTypesWithValues = [
        self::AMOUNT_TYPE_PERCENTAGE => 'درصدی',
        self::AMOUNT_TYPE_PRICE => 'عددی'
    ];

    /**
     * @return bool
     */
    public function isTypePercentage(): bool
    {
        return $this->amount_type == self::AMOUNT_TYPE_PERCENTAGE;
    }
}

<?php

namespace Modules\Attribute\Traits;

trait HasTypesTrait
{
    public const TYPE_SIMPLE = 0;
    public const TYPE_MULTIPLE = 1;

    /**
     * @var array|int[]
     */
    public static array $types = [self::TYPE_SIMPLE, self::TYPE_MULTIPLE];

    /**
     * @var array|string[]
     */
    public static array $typesWithValues = [
        self::TYPE_SIMPLE => 'ساده',
        self::TYPE_MULTIPLE => 'چند انتخابی'
    ];

    /**
     * @return string
     */
    public function getFaType(): string
    {
        return $this->type == self::TYPE_SIMPLE ? 'ساده' : 'چند انتخابی';
    }
}

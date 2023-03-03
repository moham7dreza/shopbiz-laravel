<?php

namespace Modules\Banner\Enums;

use Spatie\Enum\Enum;

/**
 * @method static self index()
 * @method static self create()
 * @method static self store()
 * @method static self edit()
 * @method static self update()
 * @method static self delete()
 * @method static self status()
 */
final class BannerRoutesEnum extends Enum
{
    protected static function values(): array
    {
        return [
            'index' => 'banner.index',
            'create' => 'banner.create',
            'store' => 'banner.store',
            'edit' => 'banner.edit',
            'update' => 'banner.update',
            'delete' => 'banner.destroy',
            'status' => 'banner.status',
        ];
    }
}

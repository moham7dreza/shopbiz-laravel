<?php

namespace Modules\Brand\Enums;

use Spatie\Enum\Enum;

final class BrandRoutesEnum extends Enum
{
    const index = 'brand.index';
    const create = 'brand.create';
    const store = 'brand.store';
    const edit = 'brand.edit';
    const update = 'brand.update';
    const destroy = 'brand.destroy';
    const status = 'brand.status';
}

<?php

namespace Modules\Banner\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Banner\Traits\HasPositionsTrait;
use Modules\Share\Traits\HasDefaultStatus;
use Modules\Share\Traits\HasFaDate;
use Modules\Share\Traits\HasFaPropertiesTrait;
use Modules\Share\Traits\HasImageTrait;

class Banner extends Model
{
    use HasFactory, SoftDeletes, HasFaDate, HasDefaultStatus, HasPositionsTrait, HasFaPropertiesTrait, HasImageTrait;

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
}

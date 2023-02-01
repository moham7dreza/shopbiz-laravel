<?php

namespace Modules\Setting\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Modules\Share\Traits\HasFaDate;
use Modules\Share\Traits\HasFaPropertiesTrait;
use Modules\Share\Traits\HasImageTrait;

class Setting extends Model
{
    use HasFactory, HasFaDate, HasImageTrait, HasFaPropertiesTrait;

    /**
     * @var string[]
     */
    protected $casts = ['logo' => 'array', 'icon' => 'array'];


    /**
     * @var string[]
     */
    protected $fillable = ['title', 'description', 'keywords', 'logo', 'icon'];
}

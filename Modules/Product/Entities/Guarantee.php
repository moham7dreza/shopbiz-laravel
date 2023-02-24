<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Modules\Share\Traits\HasDefaultStatus;
use Modules\Share\Traits\HasFaDate;


class Guarantee extends Model
{
    use HasFactory, SoftDeletes, HasFaDate, HasDefaultStatus;

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'status',
        'default_duration',
        'website_link',
    ];

    // ********************************************* Relations


    // ********************************************* Methods


    // ********************************************* FA Properties
    /**
     * @return string
     */
    public function getFaDurationTime(): string
    {
        return is_null($this->default_duration) ? '-' : convertEnglishToPersian($this->default_duration) . ' ماهه ';
    }
}

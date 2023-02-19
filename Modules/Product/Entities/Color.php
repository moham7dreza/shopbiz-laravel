<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Share\Traits\HasDefaultStatus;


class Color extends Model
{
    use HasFactory, SoftDeletes, HasDefaultStatus;

    /**
     * @var string[]
     */
    protected $fillable = ['name', 'name_en', 'code', 'status'];

    // ********************************************* Methods

    // ********************************************* FA Properties
}

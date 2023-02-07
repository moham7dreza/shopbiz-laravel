<?php

namespace Modules\Address\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends  Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['id', 'name', 'name_en', 'capital_city'];
}

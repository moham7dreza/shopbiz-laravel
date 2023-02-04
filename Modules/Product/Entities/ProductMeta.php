<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductMeta extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'product_meta';

    /**
     * @var string[]
     */
    protected $fillable = ['meta_key', 'meta_value', 'product_id'];

    // ********************************************* Relations

    // ********************************************* Methods
}

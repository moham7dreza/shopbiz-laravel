<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use Modules\Share\Traits\HasDefaultStatus;
use Modules\Share\Traits\HasFaPropertiesTrait;

class ProductColor extends Model
{
    use HasFactory, SoftDeletes, HasDefaultStatus, HasFaPropertiesTrait;

    /**
     * @var string[]
     */
    protected $fillable = ['color_name', 'color' , 'product_id', 'price_increase', 'status', 'sold_number', 'frozen_number', 'marketable_number'];


    /**
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}

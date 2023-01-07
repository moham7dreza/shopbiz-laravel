<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Gallery extends Model
{
    protected $table = 'product_images';

    use HasFactory, SoftDeletes;

    protected $fillable = ['image', 'product_id'];

    protected $casts = ['image' => 'array'];


    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }



}

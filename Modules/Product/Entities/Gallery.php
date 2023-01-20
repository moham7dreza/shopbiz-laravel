<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Share\Traits\HasFaDate;

class Gallery extends Model
{
    /**
     * @var string
     */
    protected $table = 'product_images';

    use HasFactory, SoftDeletes, HasFaDate;

    /**
     * @var string[]
     */
    protected $fillable = ['image', 'product_id'];

    /**
     * @var string[]
     */
    protected $casts = ['image' => 'array'];


    /**
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * @return string
     */
    public function imagePath(): string
    {
        return asset($this->image['indexArray']['medium']);
    }
}

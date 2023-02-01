<?php

namespace Modules\Discount\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use Modules\Share\Traits\HasDefaultStatus;
use Modules\Share\Traits\HasFaDate;
use Modules\Share\Traits\HasFaPropertiesTrait;

class CommonDiscount extends Model
{
    /**
     * @var string
     */
    protected $table = 'common_discount';

    use HasFactory, SoftDeletes, HasFaDate, HasDefaultStatus, HasFaPropertiesTrait;

    /**
     * @var string[]
     */
    protected $fillable = ['title', 'percentage', 'discount_ceiling', 'minimal_order_amount', 'start_date', 'end_date', 'status'];
}

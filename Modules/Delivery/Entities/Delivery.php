<?php

namespace Modules\Delivery\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Share\Traits\HasDefaultStatus;
use Modules\Share\Traits\HasFaDate;
use Modules\Share\Traits\HasFaPropertiesTrait;

class Delivery extends Model
{
    use HasFactory, SoftDeletes, HasFaDate, HasDefaultStatus, HasFaPropertiesTrait;

    /**
     * @var string
     */
    protected $table = 'delivery';


    /**
     * @var string[]
     */
    protected $fillable = ['name', 'amount', 'delivery_time', 'delivery_time_unit', 'status'];
}

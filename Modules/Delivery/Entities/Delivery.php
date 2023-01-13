<?php

namespace Modules\Delivery\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Share\Traits\HasFaDate;

class Delivery extends Model
{
    use HasFactory, SoftDeletes, HasFaDate;

    public const STATUS_ACTIVE = 1;
    public const STATUS_INACTIVE = 0;

    public static array $statuses = [self::STATUS_ACTIVE, self::STATUS_INACTIVE];

    protected $table = 'delivery';


    protected $fillable = ['name', 'amount', 'delivery_time', 'delivery_time_unit', 'status'];

    // methods

    public function faAmount(): string|int
    {
        return priceFormat($this->amount) ?? 0;
    }
}

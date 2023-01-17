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

    /**
     * @var array|int[]
     */
    public static array $statuses = [self::STATUS_ACTIVE, self::STATUS_INACTIVE];

    /**
     * @var string
     */
    protected $table = 'delivery';


    /**
     * @var string[]
     */
    protected $fillable = ['name', 'amount', 'delivery_time', 'delivery_time_unit', 'status'];

    // methods

    /**
     * @return string|int
     */
    public function faAmount(): string|int
    {
        return priceFormat($this->amount). ' تومان' ?? 0;
    }

    /**
     * @return string
     */
    public function deliveryTime(): string
    {
        return convertEnglishToPersian($this->delivery_time) . ' - ' . $this->delivery_time_unit . ' کاری'?? 'روز کاری تعریف نشده.';
    }

    /**
     * @return string
     */
    public function explainDeliveryTime(): string
    {
        return 'تامین کالا از ' . convertEnglishToPersian($this->delivery_time) . $this->delivery_time_unit . ' کاری آینده';
    }
}

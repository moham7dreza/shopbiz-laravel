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
    use HasFactory, SoftDeletes, HasFaDate, HasDefaultStatus;

    /**
     * @var string
     */
    protected $table = 'delivery';


    /**
     * @var string[]
     */
    protected $fillable = ['name', 'amount', 'delivery_time', 'delivery_time_unit', 'status'];

    // ********************************************* Relations

    // ********************************************* Methods

    // ********************************************* paths

    // ********************************************* FA Properties

    /**
     * @return string|int
     */
    public function getFaAmount(): string|int
    {
        return priceFormat($this->amount). ' تومان' ?? 0;
    }

    /**
     * @return string
     */
    public function getFaDeliveryTime(): string
    {
        return convertEnglishToPersian($this->delivery_time) . ' - ' . $this->delivery_time_unit . ' کاری'?? 'روز کاری تعریف نشده.';
    }

    // ********************************************* home

    /**
     * @return string
     */
    public function explainDeliveryTime(): string
    {
        return 'تامین کالا از ' . convertEnglishToPersian($this->delivery_time) . ' ' . $this->delivery_time_unit . ' کاری آینده';
    }
}

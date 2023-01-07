<?php

namespace Modules\Discount\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Share\Traits\HasFaDate;
use Modules\User\Entities\User;

class Copan extends Model
{
    use HasFactory;

    use HasFactory, SoftDeletes, HasFaDate;

    public const STATUS_ACTIVE = 1;
    public const STATUS_INACTIVE = 0;

    public static array $statuses = [self::STATUS_ACTIVE, self::STATUS_INACTIVE];

    protected $fillable = ['code', 'amount', 'amount_type' , 'discount_ceiling' , 'type' , 'user_id' ,'start_date', 'end_date', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

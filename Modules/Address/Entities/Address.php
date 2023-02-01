<?php

namespace Modules\Address\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Share\Traits\HasDefaultStatus;
use Modules\User\Entities\User;

class Address extends Model
{
    use HasFactory, HasDefaultStatus;

    /**
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'city_id',
        'province_id',
        'address',
        'postal_code',
        'no',
        'unit',
        'recipient_first_name',
        'recipient_last_name',
        'mobile',
        'status'
    ];

    /**
     * @return BelongsTo
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo
     */
    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class);
    }
}

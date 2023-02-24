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

    // ********************************************* relations

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

    // ********************************************* methods

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->user->fullName ?? $this->user->first_name ?? '-';
    }

    /**
     * @return string
     */
    public function getCityName(): string
    {
        return $this->city->name ?? '-';
    }

    /**
     * @return string
     */
    public function getProvinceName(): string
    {
        return $this->province->name ?? '-';
    }

    /**
     * @return array|string
     */
    public function getFaPostalCode(): array|string
    {
        return convertEnglishToPersian($this->postal_code) ?? '-';
    }

    /**
     * @return string
     */
    public function generateFullAddress(): string
    {
        return $this->province->name . '،  ' . $this->city->name . '،  ' . $this->address;
    }
}

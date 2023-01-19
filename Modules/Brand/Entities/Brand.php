<?php

namespace Modules\Brand\Entities;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Share\Traits\HasFaDate;

class Brand extends Model
{
    use HasFactory, SoftDeletes, Sluggable, HasFaDate;

    public const STATUS_ACTIVE = 1;
    public const STATUS_INACTIVE = 0;

    /**
     * @var array|int[]
     */
    public static array $statuses = [self::STATUS_ACTIVE, self::STATUS_INACTIVE];

    /**
     * @return array[]
     */
    public function sluggable(): array
    {
        return[
            'slug' =>[
                'source' => 'original_name'
            ]
        ];
    }

    /**
     * @var string[]
     */
    protected $casts = ['logo' => 'array'];


    /**
     * @var string[]
     */
    protected $fillable = ['persian_name', 'original_name', 'slug', 'logo', 'status', 'tags'];

    // Methods

    /**
     * @return string
     */
    public function logo(): string
    {
        return asset($this->logo['indexArray']['medium']);
    }

    /**
     * @return string
     */
    public function cssStatus(): string
    {
        if ($this->status === self::STATUS_ACTIVE) return 'success';
        else if ($this->status === self::STATUS_INACTIVE) return 'danger';
        else return 'warning';
    }

    /**
     * @return string
     */
    public function textStatus(): string
    {
        return $this->status === self::STATUS_ACTIVE ? 'فعال' : 'غیر فعال';
    }

}

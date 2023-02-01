<?php

namespace Modules\Brand\Entities;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Share\Traits\HasDefaultStatus;
use Modules\Share\Traits\HasFaDate;

class Brand extends Model
{
    use HasFactory, SoftDeletes, Sluggable, HasFaDate, HasDefaultStatus;

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
        return asset($this->logo);
    }
}

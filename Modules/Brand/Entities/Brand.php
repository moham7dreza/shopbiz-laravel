<?php

namespace Modules\Brand\Entities;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Share\Traits\HasDefaultStatus;
use Modules\Share\Traits\HasFaDate;
use Modules\Share\Traits\HasImageTrait;
use Spatie\Tags\HasTags;

class Brand extends Model
{
    use HasFactory, SoftDeletes, Sluggable, HasFaDate, HasDefaultStatus, HasTags, HasImageTrait;

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
    protected $fillable = ['persian_name', 'original_name', 'slug', 'logo', 'status'];
}

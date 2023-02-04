<?php

namespace Modules\Page\Entities;


use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Modules\Share\Traits\HasDefaultStatus;
use Modules\Share\Traits\HasFaDate;

class Page extends Model
{
    use HasFactory, SoftDeletes, Sluggable, HasFaDate, HasDefaultStatus;

    /**
     * @return array[]
     */
    public function sluggable(): array
    {
        return[
            'slug' =>[
                'source' => 'title'
            ]
        ];
    }

    /**
     * @var string[]
     */
    protected $fillable = ['title', 'body', 'slug', 'status', 'tags'];

    // ********************************************* Relations

    // ********************************************* methods

    /**
     * @param int $size
     * @return string
     */
    public function getLimitedTitle(int $size = 50): string
    {
        return Str::limit($this->title, 50);
    }
}

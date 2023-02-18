<?php

namespace Modules\Page\Entities;


use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Modules\Share\Traits\HasDefaultStatus;
use Modules\Share\Traits\HasFaDate;
use Spatie\Tags\HasTags;

class Page extends Model
{
    use HasFactory, SoftDeletes, Sluggable, HasFaDate, HasDefaultStatus, HasTags;

    /**
     * @return array[]
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    /**
     * @var string[]
     */
    protected $fillable = ['title', 'body', 'slug', 'status'];

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

    /**
     * @param int $size
     * @return string
     */
    public function getLimitedBody(int $size = 50): string
    {
        return Str::limit($this->body, 50);
    }

    /**
     * @param $limit
     * @return string
     */
    public function getTagLessBody($limit = null): string
    {
        return is_null($limit) ? strip_tags($this->body) : strip_tags($this->getLimitedBody($limit));
    }
}

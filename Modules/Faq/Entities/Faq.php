<?php

namespace Modules\Faq\Entities;


use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Modules\Share\Traits\HasDefaultStatus;
use Modules\Share\Traits\HasFaDate;

use Spatie\Tags\HasTags;

class Faq extends Model
{
    use HasFactory, SoftDeletes, Sluggable, HasFaDate, HasDefaultStatus, HasTags;

    /**
     * @return array[]
     */
    public function sluggable(): array
    {
        return[
            'slug' =>[
                'source' => 'question'
            ]
        ];
    }

    /**
     * @var string[]
     */
    protected $fillable = ['question', 'answer', 'slug', 'status'];

    // ********************************************* Relations

    // ********************************************* Methods

    /**
     * @param int $size
     * @return string
     */
    public function getLimitedQuestion(int $size = 50): string
    {
        return Str::limit($this->question, $size);
    }

    /**
     * @param int $size
     * @return string
     */
    public function getLimitedAnswer(int $size = 50): string
    {
        return Str::limit($this->answer, 50);
    }

    // ********************************************* paths

    // ********************************************* FA Properties

}

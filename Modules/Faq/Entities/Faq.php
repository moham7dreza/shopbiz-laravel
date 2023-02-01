<?php

namespace Modules\Faq\Entities;


use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Modules\Share\Traits\HasDefaultStatus;
use Modules\Share\Traits\HasFaDate;

class Faq extends Model
{
    use HasFactory, SoftDeletes, Sluggable, HasFaDate, HasDefaultStatus;

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
    protected $fillable = ['question', 'answer', 'slug', 'status', 'tags'];

    // methods

    /**
     * @return string
     */
    public function limitedQuestion(): string
    {
        return Str::limit($this->question, 50);
    }

    /**
     * @return string
     */
    public function limitedAnswer(): string
    {
        return Str::limit($this->answer, 50);
    }
}

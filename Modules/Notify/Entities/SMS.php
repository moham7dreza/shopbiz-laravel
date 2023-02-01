<?php

namespace Modules\Notify\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Modules\Share\Traits\HasFaDate;
use Modules\Share\Traits\HasDefaultStatus;

class SMS extends Model
{

    /**
     * @var string
     */
    protected $table = 'public_sms';

    use HasFactory, SoftDeletes, HasFaDate, HasDefaultStatus;


    /**
     * @var string[]
     */
    protected $fillable = ['title', 'body', 'status', 'published_at'];

    /**
     * @return string
     */
    public function limitedBody(): string
    {
        return Str::limit($this->body);
    }

    /**
     * @return string
     */
    public function limitedTitle(): string
    {
        return Str::limit($this->title, 50);
    }
}

<?php

namespace Modules\Notify\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Modules\Share\Traits\HasFaDate;
use Modules\Share\Traits\HasDefaultStatus;
use Modules\Share\Traits\HasFaPropertiesTrait;

class SMS extends Model
{

    /**
     * @var string
     */
    protected $table = 'public_sms';

    use HasFactory, SoftDeletes, HasFaDate, HasDefaultStatus, HasFaPropertiesTrait;


    /**
     * @var string[]
     */
    protected $fillable = ['title', 'body', 'status', 'published_at'];
}

<?php

namespace Modules\Notify\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Share\Traits\HasDefaultStatus;
use Modules\Share\Traits\HasFaDate;

class Notification extends Model
{
    use HasFactory, HasFaDate, HasDefaultStatus;

    protected $guarded = ['id'];

    protected $casts = ['data' => 'array'];
}

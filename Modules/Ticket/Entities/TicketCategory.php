<?php

namespace Modules\Ticket\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Share\Traits\HasFaDate;
use Modules\Share\Traits\HasStatus;

class TicketCategory extends Model
{
    use HasFactory, SoftDeletes, HasFaDate, HasStatus;

    /**
     * @var string[]
     */
    protected $fillable = ['name', 'status'];

}

<?php

namespace Modules\Ticket\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class TicketPriority extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'status'];
}

<?php

namespace Modules\Notify\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatAdmin extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = ['user_id'];


    // ********************************************* Relations
}

<?php

namespace Modules\ACL\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'description', 'status'];


    // access everywhere
    //******************************************************************************************************************
    public const ROLE_SUPER_ADMIN = ['name' => 'role-super-admin', 'description' => 'مدیر ارشد سیستم - دسترسی نامحدود'];

    public static array $roles = [ self::ROLE_SUPER_ADMIN ];

    public function users(){
        return $this->belongsToMany(User::class);
    }

    public function permissions(){
        return $this->belongsToMany(Permission::class);
    }

}

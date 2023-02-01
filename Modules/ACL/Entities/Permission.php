<?php

namespace Modules\ACL\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Modules\ACL\Traits\SystemPermissionsTrait;
use Modules\Share\Traits\HasCountersTrait;
use Modules\Share\Traits\HasDefaultStatus;
use Modules\Share\Traits\HasFaDate;
use Modules\Share\Traits\HasFaPropertiesTrait;
use Modules\User\Entities\User;
use Spatie\Permission\Traits\HasRoles;

class Permission extends \Spatie\Permission\Models\Permission
{
    use HasFactory, SoftDeletes, HasFaDate, SystemPermissionsTrait, HasDefaultStatus, HasRoles, HasCountersTrait, HasFaPropertiesTrait;

    /**
     * @var string[]
     */
    protected $fillable = ['name', 'description', 'status'];

//    protected $casts = ['status' => PermissionStatusEnum::class];

    // Relations

//    /**
//     * @return BelongsToMany
//     */
//    public function roles(): BelongsToMany
//    {
//        return $this->belongsToMany(Role::class);
//    }

//    /**
//     * @return BelongsToMany
//     */
//    public function users(): BelongsToMany
//    {
//        return $this->belongsToMany(User::class);
//    }

}

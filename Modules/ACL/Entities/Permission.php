<?php

namespace Modules\ACL\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Modules\ACL\Traits\SystemPermissionsTrait;
use Modules\Share\Traits\HasDefaultStatus;
use Modules\Share\Traits\HasFaDate;
use Spatie\Permission\Traits\HasRoles;

class Permission extends \Spatie\Permission\Models\Permission
{
    use HasFactory, SoftDeletes, HasRoles,
        HasFaDate, SystemPermissionsTrait, HasDefaultStatus;

    /**
     * @var string[]
     */
    protected $fillable = ['name', 'description', 'status', 'guard_name'];

//    protected $casts = ['status' => PermissionStatusEnum::class];

    // ***************************************** Relations

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

    // ********************************************* methods

    /**
     * @param int $size
     * @return string
     */
    public function getLimitedDescription(int $size = 50): string
    {
        return Str::limit($this->description, $size) ?? '-';
    }

    // ********************************************* counters

    /**
     * @return array|int|string
     */
    public function getFaRolesCount(): array|int|string
    {
        return convertEnglishToPersian($this->roles->count()) ?? 0;
    }


    /**
     * @return array|int|string
     */
    public function getFaUsersCount(): array|int|string
    {
        return convertEnglishToPersian($this->users->count()) ?? 0;
    }
}

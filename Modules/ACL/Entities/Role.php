<?php

namespace Modules\ACL\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Modules\Share\Traits\HasFaDate;
use Modules\User\Entities\User;
use Spatie\Permission\Traits\HasPermissions;

class Role extends \Spatie\Permission\Models\Role
{
    use HasFactory, SoftDeletes, HasFaDate, HasPermissions;

    public const STATUS_ACTIVE = 1;
    public const STATUS_INACTIVE = 0;

    /**
     * @var array|int[]
     */
    public static array $statuses = [self::STATUS_ACTIVE, self::STATUS_INACTIVE];

    /**
     * @var string[]
     */
    protected $fillable = ['name', 'description', 'status'];


    // access everywhere
    //******************************************************************************************************************
//    public const ROLE_SUPER_ADMIN = ['name' => 'role-super-admin', 'description' => 'مدیر ارشد سیستم - دسترسی نامحدود'];
    public const ROLE_SUPER_ADMIN = 'role super admin';

    /**
     * @var array|array[]
     */
    public static array $roles = [ self::ROLE_SUPER_ADMIN ];

    // Relations

    /**
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * @return BelongsToMany
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class);
    }

    // methods

    /**
     * @return int
     */
    public function usersCount(): int
    {
        return $this->users->count() ?? 0;
    }

    /**
     * @return int
     */
    public function permissionsCount(): int
    {
        return $this->permissions->count() ?? 0;
    }

//    /**
//     * @param $permission
//     * @return mixed
//     */
//    public function hasPermissionTo($permission): mixed
//    {
//        return $this->permissions->contains('name', $permission->name);
//    }

    /**
     * @return string
     */
    public function textStatus(): string
    {
        return $this->status === self::STATUS_ACTIVE ? 'فعال' : 'غیر فعال';
    }

    /**
     * @return string
     */
    public function cssStatus(): string
    {
        if ($this->status === self::STATUS_ACTIVE) return 'success';
        else if ($this->status === self::STATUS_INACTIVE) return 'danger';
        else return 'warning';
    }

    /**
     * @return string
     */
    public function limitedDescription(): string
    {
        return Str::limit($this->description, 50);
    }

    /**
     * @return mixed|string
     */
    public function textName(): mixed
    {
        foreach (self::$roles as $role) {
            if ($this->name == $role['name']) {
                return $role['description'];
            }
        }
        return 'نقش یافت نشد.';
    }

}

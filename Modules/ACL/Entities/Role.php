<?php

namespace Modules\ACL\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Modules\ACL\Traits\SystemRolesTrait;
use Modules\Share\Traits\HasDefaultStatus;
use Modules\Share\Traits\HasFaDate;
use Modules\User\Entities\User;
use Spatie\Permission\Traits\HasPermissions;

class Role extends \Spatie\Permission\Models\Role
{
    use HasFactory, SoftDeletes, HasFaDate, HasPermissions, HasDefaultStatus, SystemRolesTrait;

    /**
     * @var string[]
     */
    protected $fillable = ['name', 'description', 'status'];

    // Relations

    /**
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

//    /**
//     * @return BelongsToMany
//     */
//    public function permissions(): BelongsToMany
//    {
//        return $this->belongsToMany(Permission::class);
//    }

    // methods

    /**
     * @return array|int|string
     */
    public function usersCount(): array|int|string
    {
        return convertEnglishToPersian($this->users->count()) ?? 0;
    }

    /**
     * @return array|int|string
     */
    public function permissionsCount(): array|int|string
    {
        return convertEnglishToPersian($this->permissions->count()) ?? 0;
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
    public function limitedDescription(): string
    {
        return Str::limit($this->description, 50) ?? '-';
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

<?php

namespace Modules\ACL\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Modules\ACL\Enums\PermissionStatusEnum;
use Modules\ACL\Traits\DefinePermissionsTrait;
use Modules\Share\Traits\HasDefaultStatus;
use Modules\Share\Traits\HasFaDate;
use Modules\User\Entities\User;

class Permission extends Model
{
    use HasFactory, SoftDeletes, HasFaDate, DefinePermissionsTrait, HasDefaultStatus;

    /**
     * @var string[]
     */
    protected $fillable = ['name', 'description', 'status'];

//    protected $casts = ['status' => PermissionStatusEnum::class];

    // Relations

    /**
     * @return BelongsToMany
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    // methods

    /**
     * @return string
     */
    public function limitedDescription(): string
    {
        return Str::limit($this->description, 50);
    }

    /**
     * @return int
     */
    public function rolesCount(): int
    {
        return $this->roles->count() ?? 0;
    }

    /**
     * @return int
     */
    public function usersCount(): int
    {
        return $this->users->count() ?? 0;
    }
}

<?php

namespace Modules\ACL\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;
use Modules\ACL\Entities\Permission;
use Modules\ACL\Entities\Role;
use Modules\User\Entities\User;

class PermissionTableSeeder extends Seeder
{
    public function run()
    {
//        $this->createPermissionFromModel();
        $this->implementPermissionsWithSpatie();
    }

    /**
     * @return void
     */
    public function implementPermissionsWithSpatie(): void
    {
        // all system permissions
        foreach (Permission::$permissions as $permission) {
            Permission::query()->updateOrCreate(['name' => $permission, 'description' => null, 'status' => 1]);
        }

        // all system roles
        foreach (Role::$roles as $role) {
            Role::query()->updateOrCreate(['name' => $role, 'description' => null, 'status' => 1]);
        }

        $this->assignRoleToAdmin();
    }

    /**
     * @return void
     */
    private function assignRoleToAdmin(): void
    {
        // primary role and permission
        $role_super_admin = Role::query()->where('name', Role::ROLE_SUPER_ADMIN)->first();

        // assign primary permission to role
        $role_super_admin->syncPermissions(Permission::PERMISSION_SUPER_ADMIN);

        // find admin
        $super_admin = User::query()->first();
        // if user not found then create
        if (is_null($super_admin)) {
            User::query()->create([
                'first_name' => 'admin',
                'last_name' => 'admin',
                'email' => 'admin@admin.com',
                'password' => bcrypt('admin'),
                'activation' => User::ACTIVATE,
                'status' => User::STATUS_ACTIVE,
                'user_type' => User::TYPE_ADMIN
            ]);
        }
        Auth::loginUsingId($super_admin->id);

        // assign primary role and permission to super admin
        auth()->user()->syncRoles(Role::ROLE_SUPER_ADMIN);
//        $super_admin->syncPermissions([Permission::PERMISSION_SUPER_ADMIN, Permission::PERMISSION_ADMIN_PANEL]);
    }

    /**
     * Find or create permission from model.
     *
     * @return void
     */
    private function createPermissionFromModel(): void
    {
        // all system permissions
        foreach (Permission::$permissions as $permission) {
            Permission::query()->updateOrCreate(['name' => $permission['name'], 'description' => $permission['description'], 'status' => 1]);
        }

        // all system roles
        foreach (Role::$roles as $role) {
            Role::query()->updateOrCreate(['name' => $role['name'], 'description' => $role['description'], 'status' => 1]);
        }

        // primary role and permission
        $role_super_admin = Role::query()->where('name', Role::ROLE_SUPER_ADMIN['name'])->first();
        $permission_super_admin = Permission::query()->where('name', Permission::PERMISSION_SUPER_ADMIN['name'])->first();

        // assign primary permission to role
        $role_super_admin->permissions()->sync($permission_super_admin);

        // find admin
        $super_admin = User::query()->first();
        // if user not found then create
        if (is_null($super_admin)) {
            User::query()->create([
                'first_name' => 'admin',
                'last_name' => 'admin',
                'email' => 'admin@admin.com',
                'password' => bcrypt('admin'),
                'activation' => 1,
                'status' => 1,
                'user_type' => 1
            ]);
        }

        // assign primary role and permission to super admin
        $super_admin->roles()->sync($role_super_admin);
        $super_admin->permissions()->sync($permission_super_admin);
    }
}

<?php

namespace Modules\ACL\Providers;

use Database\Seeders\DatabaseSeeder;
use Exception;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Modules\ACL\Database\Seeders\PermissionSeeder;
use Modules\ACL\Database\Seeders\PermissionTableSeeder;
use Modules\ACL\Entities\Permission;
use Modules\ACL\Entities\Role;
use Modules\ACL\Policies\RolePermissionPolicy;
use Modules\ACL\Repositories\RolePermissionRepoEloquent;
use Modules\ACL\Repositories\RolePermissionRepoEloquentInterface;
use Modules\Share\Services\ShareService;
use Modules\User\Entities\User;

class AclServiceProvider extends ServiceProvider
{
    /**
     * Get namespace for acl controller.
     *
     * @var string
     */
    public string $namespace = 'Modules\ACL\Http\Controllers';

    /**
     * Get migration path.
     *
     * @var string
     */
    private string $migrationPath = '/../Database/Migrations';

    /**
     * Get view path.
     *
     * @var string
     */
    public string $viewPath = '/../Resources/Views/';

    /**
     * Get name.
     *
     * @var string
     */
    public string $name = 'ACL';

    /**
     * Get middleware route.
     *
     * @var array|string[]
     */
    public array $middlewareRoute = ['web'];

    /**
     * Get route path.
     *
     * @var string
     */
    public string $routePath = '/../Routes/acl_routes.php';

    /**
     * Register acl files.
     *
     * @return void
     */
    public function register(): void
    {
        $this->loadMigrationFiles();
        $this->loadViewFiles();
        $this->loadRouteFiles();
        $this->loadPolicyFiles();

        $this->bindSeeder();
        $this->bindRepository();

        $this->setDatabaseSeederWithPermissionSeeder();
    }

    /**
     * Boot acl service provider.
     *
     * @param RolePermissionRepoEloquentInterface $rolePermissionRepo
     * @return void
     */
    public function boot(RolePermissionRepoEloquentInterface $rolePermissionRepo): void
    {
        $this->app->booted(function () use ($rolePermissionRepo) {
//            $this->defineCurrentUserPermissionsInSystem($rolePermissionRepo);
            $this->setGateBefore();
            $this->setMenuForPanel();
        });
    }

    /**
     * Load acl migration files.
     *
     * @return void
     */
    private function loadMigrationFiles(): void
    {
        $this->loadMigrationsFrom(__DIR__ . $this->migrationPath);
    }

    /**
     * Load acl view files.
     *
     * @return void
     */
    private function loadViewFiles(): void
    {
        $this->loadViewsFrom(__DIR__ . $this->viewPath, $this->name);
    }

    /**
     * Load acl route files.
     *
     * @return void
     */
    private function loadRouteFiles(): void
    {
        Route::middleware($this->middlewareRoute)
            ->namespace($this->namespace)
            ->group(__DIR__ . $this->routePath);
    }

    /**
     * Load acl policy files.
     *
     * @return void
     */
    private function loadPolicyFiles(): void
    {
        Gate::policy(Role::class, RolePermissionPolicy::class);
    }

    /**
     * Set menu for acl.
     *
     * @return void
     */
    private function setMenuForPanel(): void
    {
        config()->set('panelConfig.menus.users.role-permissions', [
            'title' => 'سطوح دسترسی',
            'icon' => 'fa-user-graduate',
            'url' => route('role.index'),
        ]);
    }

    /**
     * Bind permission seeder.
     *
     * @return void
     */
    private function bindSeeder(): void
    {
        $this->app->bind(PermissionSeeder::class, PermissionTableSeeder::class);
    }


    /**
     * @param $rolePermissionRepo
     * @return void
     */
    private function defineCurrentUserPermissionsInSystem($rolePermissionRepo): void
    {
        $rolePermissionRepo->getAllPermissions()->map(function ($permission) {
            Gate::define($permission->name, function (User $user) use ($permission) {
                return $user->hasPermissionTo($permission) ? true : null;
            });
        });
//        try {
//
//
//        } catch (Exception $e) {
//            report($e);
//            return false;
//        }
//        return false;
//        Blade::directive('role', function ($role) {
        /*            return "<?php if(auth()->check() && auth()->user()->hasRole($role)) : ?>";*/
//        });
//
//        Blade::directive('endrole', function ($role) {
        /*            return "<?php endif; ?>";*/
//        });
    }

    /**
     * Set database seeder with permission seeder.
     *
     * @return void
     */
    private function setDatabaseSeederWithPermissionSeeder(): void
    {
        DatabaseSeeder::$seeders[] = PermissionSeeder::class;
    }


    /**
     * @return void
     */
    private function setGateBefore(): void
    {
        Gate::before(static function (User $user) {
            return $user->hasPermissionTo(Permission::PERMISSION_SUPER_ADMIN) ? true : null;
//            return ShareService::checkForAdmin($user);
//            return ShareService::checkForUserHasSpecialPermission(permission: Permission::PERMISSION_SUPER_ADMIN);
        });
    }

    /**
     * Bind permission repository.
     *
     * @return void
     */
    private function bindRepository(): void
    {
        $this->app->bind(RolePermissionRepoEloquentInterface::class, RolePermissionRepoEloquent::class);
    }
}

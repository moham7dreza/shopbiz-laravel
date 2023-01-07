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
use Modules\ACL\Repositories\RolePermissionRepoEloquent;
use Modules\ACL\Repositories\RolePermissionRepoEloquentInterface;

class AclServiceProvider extends ServiceProvider
{
    /**
     * Get namespace for panel controller.
     *
     * @var string
     */
    public string $namespace = 'Modules\ACL\Http\Controllers';

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
     * Get config path.
     *
     * @var string
     */
    public string $configPath = '/../Config/config.php';

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
     * Register panel files.
     *
     * @return void
     */
    public function register()
    {
        $this->loadViewFiles();
//        $this->loadConfigFiles();
        $this->loadRouteFiles();
//        $this->loadPolicyFiles();

        $this->bindSeeder();
        $this->bindRepository();

        $this->setDatabaseSeederWithPermissionSeeder();


        $this->setGateBefore();
    }

    /**
     * Boot panel service provider.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->booted(function () {
            $this->defineSystemPermissions();
//            $this->setMenuForPanel();
        });
    }

    /**
     * Load panel view files.
     *
     * @return void
     */
    private function loadViewFiles(): void
    {
        $this->loadViewsFrom(__DIR__ . $this->viewPath, $this->name);
    }

    /**
     * Load panel config files.
     *
     * @return void
     */
    private function loadConfigFiles(): void
    {
        $this->mergeConfigFrom(__DIR__ . $this->configPath, 'panelConfig');
    }

    /**
     * Load panel route files.
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
     * Load panel policy files.
     *
     * @return void
     */
    private function loadPolicyFiles(): void
    {
//        Gate::policy(Panel::class, PanelPolicy::class);
    }

    /**
     * Set menu for panel.
     *
     * @return void
     */
    private function setMenuForPanel(): void
    {
        config()->set('panelConfig.menus.role-permissions', [
            'title' => 'Role & Permissions',
            'icon' => 'alert-triangle',
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

    private function defineSystemPermissions()
    {
        try {
            Permission::query()->get()->map(function ($permission) {
                Gate::define($permission->name, function ($user) use ($permission) {
                    return $user->hasPermissionTo($permission);
                });
            });

        } catch (Exception $e) {
            report($e);
            return false;
        }

        return false;


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
     * Set gate before for super admin permission.
     *
     * @return void
     */
    private function setGateBefore(): void
    {
//        Gate::before(static function ($user) {
//            return $user->hasPermissionTo(Permission::PERMISSION_SUPER_ADMIN) ? true : null;
//        });

        Gate::before(function ($user) {
            $permission = Permission::query()->where([
                ['name', Permission::PERMISSION_SUPER_ADMIN['name']],
                ['status', 1]
            ])->first();
            if (is_null($permission))
                return false;
            if ($user->user_type == 1 && $user->hasPermissionTo($permission))
                return true;
            return false;
        });
    }

    /**
     * Bind permission repository.
     *
     * @return void
     */
    private function bindRepository()
    {
        $this->app->bind(RolePermissionRepoEloquentInterface::class, RolePermissionRepoEloquent::class);
    }
}

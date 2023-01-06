<?php

namespace Modules\ACL\Providers;

use Database\Seeders\DatabaseSeeder;
use Exception;
use Modules\ACL\Database\Seeders\PermissionSeeder;
use Modules\ACL\Entities\Permission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

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
        $this->defineSystemPermissions();
        $this->app->booted(function () {
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
        config()->set('panelConfig.menus.panel', [
            'title' => 'خانه',
            'icon' => 'home',
            'url' => route('panel.index'),
        ]);
    }

    private function defineSystemPermissions(): void
    {
        try {

            Permission::query()->get()->map(function ($permission) {
                Gate::define($permission->name, function ($user) use ($permission){
                    return $user->hasPermissionTo($permission);
                });
            });

        } catch (Exception $e) {
            report($e);
            return;
        }


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
        Gate::before(static function ($user) {
            return $user->hasPermissionTo(Permission::PERMISSION_SUPER_ADMIN) ? true : null;
        });
    }
}

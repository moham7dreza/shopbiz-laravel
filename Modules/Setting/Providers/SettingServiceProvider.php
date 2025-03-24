<?php

namespace Modules\Setting\Providers;

use Database\Seeders\DatabaseSeeder;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Modules\Setting\Database\Seeders\SettingSeeder;
use Modules\Setting\Entities\Setting;
use Modules\Setting\Policies\SettingPolicy;
use Modules\Setting\Repositories\SettingRepoEloquent;
use Modules\Setting\Repositories\SettingRepoEloquentInterface;
use Modules\Setting\Services\SettingService;
use Modules\Setting\Services\SettingServiceInterface;

class SettingServiceProvider extends ServiceProvider
{
    /**
     * Get namespace for panel controller.
     *
     * @var string
     */
    public string $namespace = 'Modules\Setting\Http\Controllers';

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
    public string $name = 'Setting';

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
    public string $routePath = '/../Routes/setting_routes.php';
    public string $apiRoutePath = '/../Routes/setting_api_routes.php';

    /**
     * Register panel files.
     *
     * @return void
     */
    public function register(): void
    {
        $this->loadMigrationFiles();
        $this->loadViewFiles();
        $this->loadRouteFiles();
        $this->loadPolicyFiles();
        $this->bindServices();
        $this->bindRepository();
        $this->setDatabaseSeederWithSettingSeeder();
    }

    /**
     * Boot panel service provider.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->app->booted(function () {
            $this->setMenuForPanel();
        });
    }

    /**
     * Load product migration files.
     *
     * @return void
     */
    private function loadMigrationFiles(): void
    {
        $this->loadMigrationsFrom(__DIR__ . $this->migrationPath);
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
     * Load panel route files.
     *
     * @return void
     */
    private function loadRouteFiles(): void
    {
        Route::middleware($this->middlewareRoute)
            ->namespace($this->namespace)
            ->group(__DIR__ . $this->routePath);
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace . '\Api')
            ->group(__DIR__ . $this->apiRoutePath);
    }

    /**
     * Load panel policy files.
     *
     * @return void
     */
    private function loadPolicyFiles(): void
    {
        Gate::policy(Setting::class, SettingPolicy::class);
    }

    /**
     * Set menu for panel.
     *
     * @return void
     */
    private function setMenuForPanel(): void
    {
        config()->set('panelConfig.menus.settings.setting', [
            'title' => 'تنظیمات',
            'icon' => 'fa-tools',
//            'url' => route('setting.index'),
        ]);
    }

    /**
     * @return void
     */
    private function bindRepository(): void
    {
        $this->app->bind(SettingRepoEloquentInterface::class, SettingRepoEloquent::class);
    }

    /**
     * @return void
     */
    private function bindServices(): void
    {
        $this->app->bind(SettingServiceInterface::class, SettingService::class);
    }

    /**
     * Set database seeder with permission seeder.
     *
     * @return void
     */
    private function setDatabaseSeederWithSettingSeeder(): void
    {
        DatabaseSeeder::$seeders[] = SettingSeeder::class;
    }
}

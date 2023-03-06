<?php

namespace Modules\Menu\Providers;

use Database\Seeders\DatabaseSeeder;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Modules\Menu\Database\Seeders\MenuSeeder;
use Modules\Menu\Entities\Menu;
use Modules\Menu\Policies\MenuPolicy;
use Modules\Menu\Repositories\MenuRepoEloquent;
use Modules\Menu\Repositories\MenuRepoEloquentInterface;

class MenuServiceProvider extends ServiceProvider
{
    /**
     * Get namespace for menu controller.
     *
     * @var string
     */
    public string $namespace = 'Modules\Menu\Http\Controllers';

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
    public string $name = 'Menu';

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
    public string $routePath = '/../Routes/menu_routes.php';
    public string $apiRoutePath = '/../Routes/menu_api_routes.php';

    /**
     * Register menu files.
     *
     * @return void
     */
    public function register(): void
    {
        $this->loadMigrationFiles();
        $this->loadViewFiles();
        $this->loadRouteFiles();
        $this->loadPolicyFiles();
        $this->bindRepository();
        $this->setDatabaseSeederWithMenuSeeder();
    }

    /**
     * Boot menu service provider.
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
     * Load menu migration files.
     *
     * @return void
     */
    private function loadMigrationFiles(): void
    {
        $this->loadMigrationsFrom(__DIR__ . $this->migrationPath);
    }

    /**
     * Load menu view files.
     *
     * @return void
     */
    private function loadViewFiles(): void
    {
        $this->loadViewsFrom(__DIR__ . $this->viewPath, $this->name);
    }

    /**
     * Load menu route files.
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
     * Load menu policy files.
     *
     * @return void
     */
    private function loadPolicyFiles(): void
    {
        Gate::policy(Menu::class, MenuPolicy::class);
    }

    /**
     * Set menu for menu.
     *
     * @return void
     */
    private function setMenuForPanel(): void
    {
        config()->set('panelConfig.menus.panel.content.menu', [
            'title' => 'منوها',
            'icon' => 'fa-link',
            'url' => route('menu.index'),
        ]);
    }

    /**
     * @return void
     */
    private function bindRepository(): void
    {
        $this->app->bind(MenuRepoEloquentInterface::class, MenuRepoEloquent::class);
    }

    /**
     * Set database seeder with permission seeder.
     *
     * @return void
     */
    private function setDatabaseSeederWithMenuSeeder(): void
    {
        DatabaseSeeder::$seeders[] = MenuSeeder::class;
    }
}

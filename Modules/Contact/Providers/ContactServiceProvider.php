<?php

namespace Modules\Contact\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Modules\Contact\Repositories\ContactRepoEloquent;
use Modules\Contact\Repositories\ContactRepoEloquentInterface;

class ContactServiceProvider extends ServiceProvider
{
    /**
     * Get namespace for home controller.
     *
     * @var string
     */
    public string $namespace = 'Modules\Contact\Http\Controllers';

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
    public string $name = 'Contact';

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
    public string $routePath = '/../Routes/contact_routes.php';

    /**
     * Get migration path.
     *
     * @var string
     */
    private string $migrationPath = '/../Database/Migrations';

    /**
     * Register home files.
     *
     * @return void
     */
    public function register(): void
    {
        $this->loadViewFiles();
        $this->loadRouteFiles();
        $this->bindRepository();
        $this->loadMigrationFiles();
    }

    /**
     * Load brand migration files.
     *
     * @return void
     */
    private function loadMigrationFiles(): void
    {
        $this->loadMigrationsFrom(__DIR__ . $this->migrationPath);
    }

    /**
     * Load home view files.
     *
     * @return void
     */
    private function loadViewFiles(): void
    {
        $this->loadViewsFrom(__DIR__ . $this->viewPath, $this->name);
    }

    /**
     * Load home route files.
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
     * Set menu for home.
     *
     * @return void
     */
    private function setMenuForPanel(): void
    {
        config()->set('panelConfig.menus.home', [
            'title' => 'فروشگاه',
            'icon' => 'fa-store',
//            'url' => route('customer.home'),
        ]);
    }

    /**
     * @return void
     */
    private function bindRepository(): void
    {
        $this->app->bind(ContactRepoEloquentInterface::class, ContactRepoEloquent::class);
    }
}

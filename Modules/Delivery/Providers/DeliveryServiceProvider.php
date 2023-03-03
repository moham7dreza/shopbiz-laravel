<?php

namespace Modules\Delivery\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Modules\Delivery\Entities\Delivery;
use Modules\Delivery\Policies\DeliveryPolicy;
use Modules\Delivery\Repositories\DeliveryRepoEloquent;
use Modules\Delivery\Repositories\DeliveryRepoEloquentInterface;

class DeliveryServiceProvider extends ServiceProvider
{
    /**
     * Get namespace for delivery controller.
     *
     * @var string
     */
    public string $namespace = 'Modules\Delivery\Http\Controllers';

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
     * Get config path.
     *
     * @var string
     */
    public string $configPath = '/../Config/routes.php';

    /**
     * Get name.
     *
     * @var string
     */
    public string $name = 'Delivery';

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
    public string $routePath = '/../Routes/delivery_routes.php';

    /**
     * Register delivery files.
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
        $this->loadConfigFiles();
    }

    /**
     * Boot delivery service provider.
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
     * Load delivery config files.
     *
     * @return void
     */
    private function loadConfigFiles(): void
    {
        $this->mergeConfigFrom(__DIR__ . $this->configPath, 'DeliveryConfig');
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
     * Load delivery view files.
     *
     * @return void
     */
    private function loadViewFiles(): void
    {
        $this->loadViewsFrom(__DIR__ . $this->viewPath, $this->name);
    }

    /**
     * Load delivery route files.
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
     * Load delivery policy files.
     *
     * @return void
     */
    private function loadPolicyFiles(): void
    {
        Gate::policy(Delivery::class, DeliveryPolicy::class);
    }

    /**
     * Set menu for delivery.
     *
     * @return void
     */
    private function setMenuForPanel(): void
    {
        config()->set('panelConfig.menus.market.delivery', [
            'title' => 'روش های ارسال',
            'icon' => 'fa-truck-loading',
            'url' => route('delivery.index'),
        ]);
    }

    /**
     * Bind delivery repository.
     *
     * @return void
     */
    private function bindRepository(): void
    {
        $this->app->bind(DeliveryRepoEloquentInterface::class, DeliveryRepoEloquent::class);
    }
}

<?php

namespace Modules\Attribute\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Modules\Attribute\Repositories\Property\PropertyRepoEloquent;
use Modules\Attribute\Repositories\Property\PropertyRepoEloquentInterface;
use Modules\Attribute\Repositories\PropertyValue\PropertyValueRepoEloquent;
use Modules\Attribute\Repositories\PropertyValue\PropertyValueRepoEloquentInterface;
use Modules\Attribute\Services\Property\PropertyService;
use Modules\Attribute\Services\Property\PropertyServiceInterface;
use Modules\Attribute\Services\PropertyValue\PropertyValueService;
use Modules\Attribute\Services\PropertyValue\PropertyValueServiceInterface;

class AttributeServiceProvider extends ServiceProvider
{
    /**
     * Get namespace for attribute controller.
     *
     * @var string
     */
    public string $namespace = 'Modules\Attribute\Http\Controllers';

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
    public string $name = 'Attribute';

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
    public string $routePath = '/../Routes/attribute_routes.php';

    /**
     * Register attribute files.
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
    }

    /**
     * Boot attribute service provider.
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
     * Load attribute migration files.
     *
     * @return void
     */
    private function loadMigrationFiles(): void
    {
        $this->loadMigrationsFrom(__DIR__ . $this->migrationPath);
    }

    /**
     * Load attribute view files.
     *
     * @return void
     */
    private function loadViewFiles(): void
    {
        $this->loadViewsFrom(__DIR__ . $this->viewPath, $this->name);
    }

    /**
     * Load attribute route files.
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
     * Load attribute policy files.
     *
     * @return void
     */
    private function loadPolicyFiles(): void
    {

    }

    /**
     * Set menu for attribute.
     *
     * @return void
     */
    private function setMenuForPanel(): void
    {

    }

    /**
     * Bind attribute repository.
     *
     * @return void
     */
    private function bindRepository(): void
    {
        $this->app->bind(PropertyRepoEloquentInterface::class, PropertyRepoEloquent::class);
        $this->app->bind(PropertyValueRepoEloquentInterface::class, PropertyValueRepoEloquent::class);
    }

    /**
     * Bind attribute repository.
     *
     * @return void
     */
    private function bindServices(): void
    {
        $this->app->bind(PropertyServiceInterface::class, PropertyService::class);
        $this->app->bind(PropertyValueServiceInterface::class, PropertyValueService::class);
    }
}

<?php

namespace Modules\Attribute\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Modules\Attribute\Repositories\Attribute\AttributeRepoEloquent;
use Modules\Attribute\Repositories\Attribute\AttributeRepoEloquentInterface;
use Modules\Attribute\Repositories\AttributeValue\AttributeValueRepoEloquent;
use Modules\Attribute\Repositories\AttributeValue\AttributeValueRepoEloquentInterface;
use Modules\Attribute\Services\Attribute\AttributeService;
use Modules\Attribute\Services\Attribute\AttributeServiceInterface;
use Modules\Attribute\Services\AttributeValue\AttributeValueService;
use Modules\Attribute\Services\AttributeValue\AttributeValueServiceInterface;

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
    public string $apiRoutePath = '/../Routes/attribute_api_routes.php';

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
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace . '\Api')
            ->group(__DIR__ . $this->apiRoutePath);
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
        $this->app->bind(AttributeRepoEloquentInterface::class, AttributeRepoEloquent::class);
        $this->app->bind(AttributeValueRepoEloquentInterface::class, AttributeValueRepoEloquent::class);
    }

    /**
     * Bind attribute repository.
     *
     * @return void
     */
    private function bindServices(): void
    {
        $this->app->bind(AttributeServiceInterface::class, AttributeService::class);
        $this->app->bind(AttributeValueServiceInterface::class, AttributeValueService::class);
    }
}

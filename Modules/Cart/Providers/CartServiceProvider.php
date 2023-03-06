<?php

namespace Modules\Cart\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Modules\Cart\Repositories\CartRepoEloquent;
use Modules\Cart\Repositories\CartRepoEloquentInterface;
use Modules\Cart\Services\CartService;
use Modules\Cart\Services\CartServiceInterface;

class CartServiceProvider extends ServiceProvider
{
    /**
     * Get namespace for cart controller.
     *
     * @var string
     */
    public string $namespace = 'Modules\Cart\Http\Controllers';

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
    public string $name = 'Cart';

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
    public string $routePath = '/../Routes/cart_routes.php';
    public string $apiRoutePath = '/../Routes/cart_api_routes.php';

    /**
     * Register cart files.
     *
     * @return void
     */
    public function register(): void
    {
        $this->loadMigrationFiles();
        $this->loadViewFiles();
        $this->loadRouteFiles();
        $this->bindRepository();
        $this->bindServices();
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
     * Load cart view files.
     *
     * @return void
     */
    private function loadViewFiles(): void
    {
        $this->loadViewsFrom(__DIR__ . $this->viewPath, $this->name);
    }

    /**
     * Load cart route files.
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
     * Bind cart repository.
     *
     * @return void
     */
    private function bindRepository(): void
    {
        $this->app->bind(CartRepoEloquentInterface::class, CartRepoEloquent::class);
    }

    /**
     * Bind cart repository.
     *
     * @return void
     */
    private function bindServices(): void
    {
        $this->app->bind(CartServiceInterface::class, CartService::class);
    }
}

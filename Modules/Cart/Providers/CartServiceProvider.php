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
     * Get namespace for panel controller.
     *
     * @var string
     */
    public string $namespace = 'Modules\Cart\Http\Controllers';

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

    /**
     * Register panel files.
     *
     * @return void
     */
    public function register()
    {
        $this->loadViewFiles();
        $this->loadRouteFiles();
        $this->bindRepository();
        $this->bindServices();
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
    }

    /**
     * Bind permission repository.
     *
     * @return void
     */
    private function bindRepository()
    {
        $this->app->bind(CartRepoEloquentInterface::class, CartRepoEloquent::class);
    }

    /**
     * Bind permission repository.
     *
     * @return void
     */
    private function bindServices()
    {
        $this->app->bind(CartServiceInterface::class, CartService::class);
    }
}

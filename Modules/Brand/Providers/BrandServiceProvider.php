<?php

namespace Modules\Brand\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Modules\Brand\Entities\Brand;
use Modules\Brand\Policies\BrandPolicy;
use Modules\Brand\Repositories\BrandRepoEloquent;
use Modules\Brand\Repositories\BrandRepoEloquentInterface;

class BrandServiceProvider extends ServiceProvider
{
    /**
     * Get namespace for brand controller.
     *
     * @var string
     */
    public string $namespace = 'Modules\Brand\Http\Controllers';

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
    public string $name = 'Brand';

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
    public string $routePath = '/../Routes/brand_routes.php';
    public string $apiRoutePath = '/../Routes/brand_api_routes.php';

    /**
     * Register brand files.
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
    }

    /**
     * Boot brand service provider.
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
     * Load brand migration files.
     *
     * @return void
     */
    private function loadMigrationFiles(): void
    {
        $this->loadMigrationsFrom(__DIR__ . $this->migrationPath);
    }

    /**
     * Load brand view files.
     *
     * @return void
     */
    private function loadViewFiles(): void
    {
        $this->loadViewsFrom(__DIR__ . $this->viewPath, $this->name);
    }

    /**
     * Load brand route files.
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
     * Load brand policy files.
     *
     * @return void
     */
    private function loadPolicyFiles(): void
    {
        Gate::policy(Brand::class, BrandPolicy::class);
    }

    /**
     * Set menu for brand.
     *
     * @return void
     */
    private function setMenuForPanel(): void
    {
        config()->set('panelConfig.menus.market.vitrine.brand', [
            'title' => 'خانه',
            'icon' => 'fa-brand',
            'url' => route('brand.index'),
        ]);
    }

    /**
     * Bind brand repository.
     *
     * @return void
     */
    private function bindRepository(): void
    {
        $this->app->bind(BrandRepoEloquentInterface::class, BrandRepoEloquent::class);
    }
}

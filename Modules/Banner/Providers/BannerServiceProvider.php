<?php

namespace Modules\Banner\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Modules\Banner\Entities\Banner;
use Modules\Banner\Entities\HasFaProperties;
use Modules\Banner\Policies\BannerPolicy;
use Modules\Banner\Repositories\BannerRepoEloquent;
use Modules\Banner\Repositories\BannerRepoEloquentInterface;

class BannerServiceProvider extends ServiceProvider
{
    /**
     * Get namespace for banner controller.
     *
     * @var string
     */
    public string $namespace = 'Modules\Banner\Http\Controllers';

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
    public string $name = 'Banner';

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
    public string $routePath = '/../Routes/banner_routes.php';
    public string $apiRoutePath = '/../Routes/banner_api_routes.php';

    /**
     * Register banner files.
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
     * Boot banner service provider.
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
     * Load banner migration files.
     *
     * @return void
     */
    private function loadMigrationFiles(): void
    {
        $this->loadMigrationsFrom(__DIR__ . $this->migrationPath);
    }

    /**
     * Load banner view files.
     *
     * @return void
     */
    private function loadViewFiles(): void
    {
        $this->loadViewsFrom(__DIR__ . $this->viewPath, $this->name);
    }

    /**
     * Load banner route files.
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
     * Load banner policy files.
     *
     * @return void
     */
    private function loadPolicyFiles(): void
    {
        Gate::policy(Banner::class, BannerPolicy::class);
    }

    /**
     * Set menu for banner.
     *
     * @return void
     */
    private function setMenuForPanel(): void
    {
        config()->set('panelConfig.menus.content.banner', [
            'title' => 'بنر تبلیغاتی',
            'icon' => 'fa-ad',
            'url' => route('banner.index'),
        ]);
    }

    /**
     * Bind banner repository.
     *
     * @return void
     */
    private function bindRepository(): void
    {
        $this->app->bind(BannerRepoEloquentInterface::class, BannerRepoEloquent::class);
        $this->app->bind(HasFaProperties::class, Banner::class);
    }
}

<?php

namespace Modules\Banner\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Modules\Banner\Entities\Banner;
use Modules\Banner\Policies\BannerPolicy;
use Modules\Banner\Repositories\BrandRepoEloquent;
use Modules\Banner\Repositories\BannerRepoEloquentInterface;

class BannerServiceProvider extends ServiceProvider
{
    /**
     * Get namespace for panel controller.
     *
     * @var string
     */
    public string $namespace = 'Modules\Banner\Http\Controllers';

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

    /**
     * Register panel files.
     *
     * @return void
     */
    public function register()
    {
        $this->loadViewFiles();
        $this->loadRouteFiles();
        $this->loadPolicyFiles();
        $this->bindRepository();
    }

    /**
     * Boot panel service provider.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->booted(function () {
            $this->setMenuForPanel();
        });
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
     * Load panel policy files.
     *
     * @return void
     */
    private function loadPolicyFiles(): void
    {
        Gate::policy(Banner::class, BannerPolicy::class);
    }

    /**
     * Set menu for panel.
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
     * Bind permission repository.
     *
     * @return void
     */
    private function bindRepository()
    {
        $this->app->bind(BannerRepoEloquentInterface::class, BrandRepoEloquent::class);
    }
}

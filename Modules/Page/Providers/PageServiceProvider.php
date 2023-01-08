<?php

namespace Modules\Page\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Modules\Page\Entities\Page;
use Modules\Page\Policies\PagePolicy;

class PageServiceProvider extends ServiceProvider
{
    /**
     * Get namespace for panel controller.
     *
     * @var string
     */
    public string $namespace = 'Modules\Page\Http\Controllers';

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
    public string $name = 'Page';

    /**
     * Get config path.
     *
     * @var string
     */
    public string $configPath = '/../Config/config.php';

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
    public string $routePath = '/../Routes/page_routes.php';

    /**
     * Register panel files.
     *
     * @return void
     */
    public function register()
    {
        $this->loadViewFiles();
//        $this->loadConfigFiles();
        $this->loadRouteFiles();
        $this->loadPolicyFiles();
    }

    /**
     * Boot panel service provider.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->booted(function () {
//            $this->setMenuForPanel();
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
     * Load panel config files.
     *
     * @return void
     */
    private function loadConfigFiles(): void
    {
        $this->mergeConfigFrom(__DIR__ . $this->configPath, 'panelConfig');
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
        Gate::policy(Page::class, PagePolicy::class);
    }

    /**
     * Set menu for panel.
     *
     * @return void
     */
    private function setMenuForPanel(): void
    {
        config()->set('panelConfig.menus.panel', [
            'title' => 'خانه',
            'icon' => 'home',
            'url' => route('panel.index'),
        ]);
    }
}

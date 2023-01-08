<?php

namespace Modules\Panel\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Modules\Comment\Entities\Comment;
use Modules\Notify\Entities\Notification;
use Modules\Panel\Entities\Panel;
use Modules\Panel\Policies\PanelPolicy;

class PanelServiceProvider extends ServiceProvider
{
    /**
     * Get namespace for panel controller.
     *
     * @var string
     */
    public string $namespace = 'Modules\Panel\Http\Controllers';
    public string $apiNamespace = 'Modules\Panel\Http\Controllers\Api';

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
    public string $name = 'Panel';

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
    public array $apiMiddlewareRoute = ['api'];

    /**
     * Get route path.
     *
     * @var string
     */
    public string $routePath = '/../Routes/panel_routes.php';
    public string $apiRoutePath = '/../Routes/panel_api_routes.php';

    /**
     * Register panel files.
     *
     * @return void
     */
    public function register()
    {
        $this->loadViewFiles();
        $this->loadConfigFiles();
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
            $this->setMenuForPanel();
            $this->sendVarsToViews();
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
     * Load panel route files.
     *
     * @return void
     */
    private function loadApiRouteFiles(): void
    {
        Route::prefix('api')
            ->middleware($this->apiMiddlewareRoute)
            ->namespace($this->apiNamespace)
            ->group(__DIR__ . $this->apiRoutePath);
    }

    /**
     * Load panel policy files.
     *
     * @return void
     */
    private function loadPolicyFiles(): void
    {
        Gate::policy(Panel::class, PanelPolicy::class);
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
            'url' => route('panel.home'),
        ]);
    }

    private function sendVarsToViews()
    {
        view()->composer('Panel::layouts.header', function ($view) {
            $view->with('unseenComments', Comment::query()->where('seen', 0)->get());
            $view->with('notifications', Notification::query()->where('read_at', null)->get());
        });
    }
}

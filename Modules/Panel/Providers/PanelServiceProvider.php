<?php

namespace Modules\Panel\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Modules\Comment\Repositories\CommentRepoEloquentInterface;
use Modules\Notify\Repositories\Notification\NotificationRepoEloquentInterface;
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
    public function register(): void
    {
        $this->loadViewFiles();
        $this->loadConfigFiles(); 
        $this->loadRouteFiles();
        $this->loadPolicyFiles();
    }

    /**
     * Boot panel service provider.
     *
     * @param CommentRepoEloquentInterface $commentRepo
     * @param NotificationRepoEloquentInterface $notificationRepo
     * @return void
     */
    public function boot(CommentRepoEloquentInterface $commentRepo, NotificationRepoEloquentInterface $notificationRepo): void
    {
        $this->app->booted(function () use ($commentRepo, $notificationRepo) {
            $this->setMenuForPanel();
            $this->sendVarsToViews($commentRepo, $notificationRepo);
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
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace . '\Api')
            ->group(__DIR__ . $this->apiRoutePath);
    }

    /**
     * Load panel route files.
     *
     * @return void
     */
    private function loadApiRouteFiles(): void
    {

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
            'icon' => 'fa-home',
            'url' => route('panel.home'),
        ]);
    }

    /**
     * @param $commentRepo
     * @param $notificationRepo
     * @return void
     */
    private function sendVarsToViews($commentRepo, $notificationRepo): void
    {
        view()->composer('Panel::layouts.header', function ($view) use ($commentRepo, $notificationRepo) {
            $view->with('unseenComments', $commentRepo->unseenComments()->get());
            $view->with('notifications', $notificationRepo->newNotifications()->get());
        });
    }
}

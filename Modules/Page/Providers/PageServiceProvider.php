<?php

namespace Modules\Page\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Modules\Page\Entities\Page;
use Modules\Page\Policies\PagePolicy;
use Modules\Page\Repositories\PageRepoEloquent;
use Modules\Page\Repositories\PageRepoEloquentInterface;

class PageServiceProvider extends ServiceProvider
{
    /**
     * Get namespace for panel controller.
     *
     * @var string
     */
    public string $namespace = 'Modules\Page\Http\Controllers';

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
    public string $name = 'Page';

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
    public string $apiRoutePath = '/../Routes/page_api_routes.php';

    /**
     * Register panel files.
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
     * Boot panel service provider.
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
     * Load product migration files.
     *
     * @return void
     */
    private function loadMigrationFiles(): void
    {
        $this->loadMigrationsFrom(__DIR__ . $this->migrationPath);
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
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace . '\Api')
            ->group(__DIR__ . $this->apiRoutePath);
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
        config()->set('panelConfig.menus.content.page', [
            'title' => 'پیج ساز',
            'icon' => 'fa-pager',
            'url' => route('page.index'),
        ]);
    }

    /**
     * @return void
     */
    private function bindRepository()
    {
        $this->app->bind(PageRepoEloquentInterface::class, PageRepoEloquent::class);
    }
}

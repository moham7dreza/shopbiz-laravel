<?php

namespace Modules\Tag\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Modules\Tag\Repositories\TagRepositoryEloquent;
use Modules\Tag\Repositories\TagRepositoryEloquentInterface;

class TagServiceProvider extends ServiceProvider
{
    /**
     * Get namespace for tag controller.
     *
     * @var string
     */
    public string $namespace = 'Modules\Tag\Http\Controllers';

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
    public string $name = 'Tag';

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
    public string $routePath = '/../Routes/tag_routes.php';

    /**
     * Register tag files.
     *
     * @return void
     */
    public function register(): void
    {
        $this->loadMigrationFiles();
        $this->loadViewFiles();
        $this->loadRouteFiles();
//        $this->loadPolicyFiles();
//        $this->bindServices();
        $this->bindRepository();
    }

    /**
     * Boot tag service provider.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->app->booted(function () {
//            $this->setMenuForPanel();
        });
    }

    /**
     * Load tag migration files.
     *
     * @return void
     */
    private function loadMigrationFiles(): void
    {
        $this->loadMigrationsFrom(__DIR__ . $this->migrationPath);
    }

    /**
     * Load tag view files.
     *
     * @return void
     */
    private function loadViewFiles(): void
    {
        $this->loadViewsFrom(__DIR__ . $this->viewPath, $this->name);
    }

    /**
     * Load tag route files.
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
     * Load tag policy files.
     *
     * @return void
     */
    private function loadPolicyFiles(): void
    {
        Gate::policy(Post::class, PostPolicy::class);
    }

    /**
     * Set menu for tag.
     *
     * @return void
     */
    private function setMenuForPanel(): void
    {
        config()->set('panelConfig.menus.content.tag', [
            'title' => 'پست ها',
            'icon' => 'fa-blog',
            'url' => route('tag.index'),
        ]);
    }

    /**
     * @return void
     */
    private function bindRepository(): void
    {
        $this->app->bind(TagRepositoryEloquentInterface::class, TagRepositoryEloquent::class);
    }

    /**
     * @return void
     */
    private function bindServices(): void
    {
        $this->app->bind(PostServiceInterface::class, PostService::class);
    }
}

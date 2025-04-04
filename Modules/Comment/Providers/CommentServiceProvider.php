<?php

namespace Modules\Comment\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Modules\Comment\Entities\Comment;
use Modules\Comment\Policies\PostCommentPolicy;
use Modules\Comment\Repositories\CommentRepoEloquent;
use Modules\Comment\Repositories\CommentRepoEloquentInterface;

class CommentServiceProvider extends ServiceProvider
{
    /**
     * Get namespace for comment controller.
     *
     * @var string
     */
    public string $namespace = 'Modules\Comment\Http\Controllers';

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
    public string $name = 'Comment';

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
    public string $routePath = '/../Routes/comment_routes.php';
    public string $apiRoutePath = '/../Routes/comment_api_routes.php';

    /**
     * Register comment files.
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
     * Boot comment service provider.
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
     * Load comment view files.
     *
     * @return void
     */
    private function loadViewFiles(): void
    {
        $this->loadViewsFrom(__DIR__ . $this->viewPath, $this->name);
    }

    /**
     * Load comment route files.
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
     * Load comment policy files.
     *
     * @return void
     */
    private function loadPolicyFiles(): void
    {
        Gate::policy(Comment::class, PostCommentPolicy::class);
    }

    /**
     * Set menu for comment.
     *
     * @return void
     */
    private function setMenuForPanel(): void
    {
        config()->set('panelConfig.menus.content.comment', [
            'title' => 'نظرات',
            'icon' => 'fa-comment',
//            'url' => route('postComment.index'),
        ]);

        config()->set('panelConfig.menus.market.vitrine.comment', [
            'title' => 'نظرات',
            'icon' => 'fa-comment',
//            'url' => route('productComment.index'),
        ]);
    }

    /**
     * Bind comment repository.
     *
     * @return void
     */
    private function bindRepository(): void
    {
        $this->app->bind(CommentRepoEloquentInterface::class, CommentRepoEloquent::class);
    }
}

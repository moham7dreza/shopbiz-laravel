<?php

namespace Modules\User\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Modules\User\Entities\User;
use Modules\User\Policies\UserPolicy;
use Modules\User\Repositories\UserRepoEloquent;
use Modules\User\Repositories\UserRepoEloquentInterface;

class UserServiceProvider extends ServiceProvider
{
    /**
     * Get namespace for user controller.
     *
     * @var string
     */
    public string $namespace = 'Modules\User\Http\Controllers';

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
    public string $name = 'User';

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
    public string $routePath = '/../Routes/user_routes.php';

    /**
     * Register user files.
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
     * Boot user service provider.
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
     * Load user migration files.
     *
     * @return void
     */
    private function loadMigrationFiles(): void
    {
        $this->loadMigrationsFrom(__DIR__ . $this->migrationPath);
    }

    /**
     * Load user view files.
     *
     * @return void
     */
    private function loadViewFiles(): void
    {
        $this->loadViewsFrom(__DIR__ . $this->viewPath, $this->name);
    }

    /**
     * Load user route files.
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
     * Load user policy files.
     *
     * @return void
     */
    private function loadPolicyFiles(): void
    {
        Gate::policy(User::class, UserPolicy::class);
    }

    /**
     * Set menu for user.
     *
     * @return void
     */
    private function setMenuForPanel(): void
    {
        config()->set('panelConfig.menus.users.admins', [
            'title' => 'کاربران ادمین',
            'icon' => 'fa-user-secret',
            'url' => route('adminUser.index'),
        ]);
    }

    /**
     * @return void
     */
    private function bindRepository(): void
    {
        $this->app->bind(UserRepoEloquentInterface::class, UserRepoEloquent::class);
    }

//    /**
//     * @return void
//     */
//    private function bindRepository()
//    {
//        $this->app->bind(SettingRepoEloquentInterface::class, SettingRepoEloquent::class);
//    }
}

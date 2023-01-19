<?php

namespace Modules\Auth\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Modules\Auth\Repositories\AuthRepoEloquent;
use Modules\Auth\Repositories\AuthRepoEloquentInterface;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Get namespace for auth controller.
     *
     * @var string
     */
    public string $namespace = 'Modules\Auth\Http\Controllers';

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
    public string $name = 'Auth';

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
    public string $routePath = '/../Routes/auth_routes.php';

    /**
     * Register auth files.
     *
     * @return void
     */
    public function register(): void
    {
        $this->loadMigrationFiles();
        $this->loadViewFiles();
        $this->loadRouteFiles();
        $this->bindRepository();
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
     * Load auth view files.
     *
     * @return void
     */
    private function loadViewFiles(): void
    {
        $this->loadViewsFrom(__DIR__ . $this->viewPath, $this->name);
    }

    /**
     * Load auth route files.
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
     * @return void
     */
    private function bindRepository(): void
    {
        $this->app->bind(AuthRepoEloquentInterface::class, AuthRepoEloquent::class);
    }

    /**
     * @param $settingRepo
     * @return void
     */
    private function sendVarsToViews($settingRepo): void
    {
        view()->composer('Auth::home.login-register', function ($view) use ($settingRepo) {
            $view->with('logo', $settingRepo->findLoginRegisterFormLogo());
        });
    }
}

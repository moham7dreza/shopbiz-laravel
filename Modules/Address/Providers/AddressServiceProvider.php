<?php

namespace Modules\Address\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Modules\Address\Entities\Address;
use Modules\Address\Repositories\AddressRepoEloquent;
use Modules\Address\Repositories\AddressRepoEloquentInterface;
use Policies\AddressPolicy;

class AddressServiceProvider extends ServiceProvider
{
    /**
     * Get namespace for address controller.
     *
     * @var string
     */
    public string $namespace = 'Modules\Address\Http\Controllers';

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
    public string $name = 'Address';

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
    public string $routePath = '/../Routes/address_routes.php';

    /**
     * Register address files.
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
     * Boot address service provider.
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
     * Load address migration files.
     *
     * @return void
     */
    private function loadMigrationFiles(): void
    {
        $this->loadMigrationsFrom(__DIR__ . $this->migrationPath);
    }

    /**
     * Load address view files.
     *
     * @return void
     */
    private function loadViewFiles(): void
    {
        $this->loadViewsFrom(__DIR__ . $this->viewPath, $this->name);
    }

    /**
     * Load address route files.
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
     * Load address policy files.
     *
     * @return void
     */
    private function loadPolicyFiles(): void
    {
        Gate::policy(Address::class, AddressPolicy::class);
    }

//    /**
//     * Set menu for address.
//     *
//     * @return void
//     */
//    private function setMenuForPanel(): void
//    {
//        config()->set('panelConfig.menus.market.vitrine.brand', [
//            'title' => 'خانه',
//            'icon' => 'fa-brand',
//            'url' => route('brand.index'),
//        ]);
//    }

    /**
     * Bind address repository.
     *
     * @return void
     */
    private function bindRepository(): void
    {
        $this->app->bind(AddressRepoEloquentInterface::class, AddressRepoEloquent::class);
    }
}

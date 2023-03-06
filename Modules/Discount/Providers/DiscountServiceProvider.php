<?php

namespace Modules\Discount\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Modules\Discount\Entities\CommonDiscount;
use Modules\Discount\Policies\DiscountPolicy;
use Modules\Discount\Repositories\AmazingSale\AmazingSaleDiscountRepoEloquent;
use Modules\Discount\Repositories\AmazingSale\AmazingSaleDiscountRepoEloquentInterface;
use Modules\Discount\Repositories\Common\CommonDiscountRepoEloquent;
use Modules\Discount\Repositories\Common\CommonDiscountRepoEloquentInterface;
use Modules\Discount\Repositories\Copan\CopanDiscountRepoEloquent;
use Modules\Discount\Repositories\Copan\CopanDiscountRepoEloquentInterface;

class DiscountServiceProvider extends ServiceProvider
{
    /**
     * Get namespace for discount controller.
     *
     * @var string
     */
    public string $namespace = 'Modules\Discount\Http\Controllers';

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
    public string $name = 'Discount';


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
    public string $routePath = '/../Routes/discount_routes.php';
    public string $apiRoutePath = '/../Routes/discount_api_routes.php';

    /**
     * Register discount files.
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
     * Boot discount service provider.
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
     * Load discount migration files.
     *
     * @return void
     */
    private function loadMigrationFiles(): void
    {
        $this->loadMigrationsFrom(__DIR__ . $this->migrationPath);
    }

    /**
     * Load discount view files.
     *
     * @return void
     */
    private function loadViewFiles(): void
    {
        $this->loadViewsFrom(__DIR__ . $this->viewPath, $this->name);
    }

    /**
     * Load discount route files.
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
     * Load discount policy files.
     *
     * @return void
     */
    private function loadPolicyFiles(): void
    {
        Gate::policy(CommonDiscount::class, DiscountPolicy::class);
    }

    /**
     * Set menu for discount.
     *
     * @return void
     */
    private function setMenuForPanel(): void
    {
        config()->set('panelConfig.menus.mark.discount', [
            'title' => 'تخفیفات',
            'icon' => 'fa-dollar-sign',
//            'url' => route('discount.copan'),
        ]);
    }

    /**
     * Bind discount repository.
     *
     * @return void
     */
    private function bindRepository(): void
    {
        $this->app->bind(CopanDiscountRepoEloquentInterface::class, CopanDiscountRepoEloquent::class);
        $this->app->bind(CommonDiscountRepoEloquentInterface::class, CommonDiscountRepoEloquent::class);
        $this->app->bind(AmazingSaleDiscountRepoEloquentInterface::class, AmazingSaleDiscountRepoEloquent::class);
    }

//    private function bindServices()
//    {
//        $this->app->bind(CopanDiscountServiceInterface::class, CopanDiscountService::class);
//        $this->app->bind(CommonDiscountServiceInterface::class, CommonDiscountService::class);
//        $this->app->bind(AmazingSaleDiscountServiceInterface::class, AmazingSaleDiscountService::class);
//    }
}

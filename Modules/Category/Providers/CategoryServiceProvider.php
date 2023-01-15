<?php

namespace Modules\Category\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Modules\Category\Entities\PostCategory;
use Modules\Category\Entities\ProductCategory;
use Modules\Category\Policies\PostCategoryPolicy;
use Modules\Category\Policies\ProductCategoryPolicy;
use Modules\Category\Repositories\PostCategory\PostCategoryRepoEloquent;
use Modules\Category\Repositories\PostCategory\PostCategoryRepoEloquentInterface;
use Modules\Category\Repositories\ProductCategory\ProductCategoryRepoEloquent;
use Modules\Category\Repositories\ProductCategory\ProductCategoryRepoEloquentInterface;
use Modules\Category\Repositories\Property\PropertyRepoEloquent;
use Modules\Category\Repositories\Property\PropertyRepoEloquentInterface;
use Modules\Category\Repositories\PropertyValue\PropertyValueRepoEloquent;
use Modules\Category\Repositories\PropertyValue\PropertyValueRepoEloquentInterface;
use Modules\Category\Services\PostCategory\PostCategoryService;
use Modules\Category\Services\PostCategory\PostCategoryServiceInterface;
use Modules\Category\Services\ProductCategory\ProductCategoryService;
use Modules\Category\Services\ProductCategory\ProductCategoryServiceInterface;
use Modules\Category\Services\Property\PropertyService;
use Modules\Category\Services\Property\PropertyServiceInterface;
use Modules\Category\Services\PropertyValue\PropertyValueService;
use Modules\Category\Services\PropertyValue\PropertyValueServiceInterface;

class CategoryServiceProvider extends ServiceProvider
{
    /**
     * Get namespace for category controller.
     *
     * @var string
     */
    public string $namespace = 'Modules\Category\Http\Controllers';

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
    public string $name = 'Category';

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
    public string $routePath = '/../Routes/category_routes.php';

    /**
     * Register category files.
     *
     * @return void
     */
    public function register(): void
    {
        $this->loadMigrationFiles();
        $this->loadViewFiles();
        $this->loadRouteFiles();
        $this->loadPolicyFiles();
        $this->bindServices();
        $this->bindRepository();
    }

    /**
     * Boot category service provider.
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
     * Load category migration files.
     *
     * @return void
     */
    private function loadMigrationFiles(): void
    {
        $this->loadMigrationsFrom(__DIR__ . $this->migrationPath);
    }

    /**
     * Load category view files.
     *
     * @return void
     */
    private function loadViewFiles(): void
    {
        $this->loadViewsFrom(__DIR__ . $this->viewPath, $this->name);
    }

    /**
     * Load category route files.
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
     * Load category policy files.
     *
     * @return void
     */
    private function loadPolicyFiles(): void
    {
        Gate::policy(ProductCategory::class, ProductCategoryPolicy::class);
        Gate::policy(PostCategory::class, PostCategoryPolicy::class);
    }

    /**
     * Set menu for category.
     *
     * @return void
     */
    private function setMenuForPanel(): void
    {
        config()->set('panelConfig.menus.market.vitrine.category', [
            'title' => 'دسته بندی',
            'icon' => 'fa-leaf',
            'url' => route('productCategory.index'),
        ]);

        config()->set('panelConfig.menus.content.category', [
            'title' => 'دسته بندی',
            'icon' => 'fa-leaf',
            'url' => route('postCategory.index'),
        ]);
    }

    /**
     * Bind category repository.
     *
     * @return void
     */
    private function bindRepository(): void
    {
        $this->app->bind(PostCategoryRepoEloquentInterface::class, PostCategoryRepoEloquent::class);
        $this->app->bind(ProductCategoryRepoEloquentInterface::class, ProductCategoryRepoEloquent::class);
        $this->app->bind(PropertyRepoEloquentInterface::class, PropertyRepoEloquent::class);
        $this->app->bind(PropertyValueRepoEloquentInterface::class, PropertyValueRepoEloquent::class);
    }

    /**
     * Bind category repository.
     *
     * @return void
     */
    private function bindServices(): void
    {
        $this->app->bind(PostCategoryServiceInterface::class, PostCategoryService::class);
        $this->app->bind(ProductCategoryServiceInterface::class, ProductCategoryService::class);
        $this->app->bind(PropertyServiceInterface::class, PropertyService::class);
        $this->app->bind(PropertyValueServiceInterface::class, PropertyValueService::class);
    }
}

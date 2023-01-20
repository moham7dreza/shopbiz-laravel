<?php

namespace Modules\Product\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Modules\Product\Entities\Product;
use Modules\Product\Policies\ProductPolicy;
use Modules\Product\Repositories\Color\ProductColorRepoEloquent;
use Modules\Product\Repositories\Color\ProductColorRepoEloquentInterface;
use Modules\Product\Repositories\Gallery\ProductGalleryRepoEloquent;
use Modules\Product\Repositories\Gallery\ProductGalleryRepoEloquentInterface;
use Modules\Product\Repositories\Guarantee\ProductGuaranteeRepoEloquent;
use Modules\Product\Repositories\Guarantee\ProductGuaranteeRepoEloquentInterface;
use Modules\Product\Repositories\Meta\ProductMetaRepoEloquent;
use Modules\Product\Repositories\Meta\ProductMetaRepoEloquentInterface;
use Modules\Product\Repositories\Product\ProductRepoEloquent;
use Modules\Product\Repositories\Product\ProductRepoEloquentInterface;
use Modules\Product\Repositories\Store\ProductStoreRepoEloquent;
use Modules\Product\Repositories\Store\ProductStoreRepoEloquentInterface;
use Modules\Product\Services\Color\ProductColorService;
use Modules\Product\Services\Color\ProductColorServiceInterface;
use Modules\Product\Services\Gallery\ProductGalleryService;
use Modules\Product\Services\Gallery\ProductGalleryServiceInterface;
use Modules\Product\Services\Guarantee\ProductGuaranteeService;
use Modules\Product\Services\Guarantee\ProductGuaranteeServiceInterface;
use Modules\Product\Services\Meta\ProductMetaService;
use Modules\Product\Services\Meta\ProductMetaServiceInterface;
use Modules\Product\Services\Product\ProductService;
use Modules\Product\Services\Product\ProductServiceInterface;
use Modules\Product\Services\Store\ProductStoreService;
use Modules\Product\Services\Store\ProductStoreServiceInterface;

class ProductServiceProvider extends ServiceProvider
{
    /**
     * Get namespace for product controller.
     *
     * @var string
     */
    public string $namespace = 'Modules\Product\Http\Controllers';

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
    public string $name = 'Product';

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
    public string $routePath = '/../Routes/product_routes.php';

    /**
     * Register product files.
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
     * Boot product service provider.
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
     * Load product view files.
     *
     * @return void
     */
    private function loadViewFiles(): void
    {
        $this->loadViewsFrom(__DIR__ . $this->viewPath, $this->name);
    }

    /**
     * Load product route files.
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
     * Load product policy files.
     *
     * @return void
     */
    private function loadPolicyFiles(): void
    {
        Gate::policy(Product::class, ProductPolicy::class);
    }

    /**
     * Set menu for product.
     *
     * @return void
     */
    private function setMenuForPanel(): void
    {
        config()->set('panelConfig.menus.market.vitrine.product', [
            'title' => 'محصولات',
            'icon' => 'fa-product',
            'url' => route('product.index'),
        ]);
    }

    /**
     * @return void
     */
    private function bindRepository(): void
    {
        $this->app->bind(ProductRepoEloquentInterface::class, ProductRepoEloquent::class);
        $this->app->bind(ProductColorRepoEloquentInterface::class, ProductColorRepoEloquent::class);
        $this->app->bind(ProductGalleryRepoEloquentInterface::class, ProductGalleryRepoEloquent::class);
        $this->app->bind(ProductGuaranteeRepoEloquentInterface::class, ProductGuaranteeRepoEloquent::class);
        $this->app->bind(ProductStoreRepoEloquentInterface::class, ProductStoreRepoEloquent::class);
        $this->app->bind(ProductMetaRepoEloquentInterface::class, ProductMetaRepoEloquent::class);
    }

    /**
     * @return void
     */
    private function bindServices(): void
    {
        $this->app->bind(ProductServiceInterface::class, ProductService::class);
        $this->app->bind(ProductColorServiceInterface::class, ProductColorService::class);
        $this->app->bind(ProductGalleryServiceInterface::class, ProductGalleryService::class);
        $this->app->bind(ProductGuaranteeServiceInterface::class, ProductGuaranteeService::class);
        $this->app->bind(ProductStoreServiceInterface::class, ProductStoreService::class);
        $this->app->bind(ProductMetaServiceInterface::class, ProductMetaService::class);
    }
}

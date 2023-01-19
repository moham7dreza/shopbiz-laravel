<?php

namespace Modules\Home\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Modules\Cart\Repositories\CartRepoEloquentInterface;
use Modules\Category\Repositories\ProductCategory\ProductCategoryRepoEloquentInterface;
use Modules\Home\Repositories\HomeRepoEloquent;
use Modules\Home\Repositories\HomeRepoEloquentInterface;
use Modules\Menu\Repositories\MenuRepoEloquentInterface;
use Modules\Setting\Repositories\SettingRepoEloquentInterface;

class HomeServiceProvider extends ServiceProvider
{
    /**
     * Get namespace for home controller.
     *
     * @var string
     */
    public string $namespace = 'Modules\Home\Http\Controllers';

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
    public string $name = 'Home';

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
    public string $routePath = '/../Routes/home_routes.php';

    /**
     * Register home files.
     *
     * @return void
     */
    public function register(): void
    {
        $this->loadViewFiles();
        $this->loadRouteFiles();
        $this->bindRepository();
    }

    /**
     * Boot home service provider.
     *
     * @param CartRepoEloquentInterface $cartRepo
     * @param MenuRepoEloquentInterface $menuRepo
     * @param ProductCategoryRepoEloquentInterface $productCategoryRepo
     * @param SettingRepoEloquentInterface $settingRepo
     * @return void
     */
    public function boot(CartRepoEloquentInterface $cartRepo, MenuRepoEloquentInterface $menuRepo,
    ProductCategoryRepoEloquentInterface $productCategoryRepo, SettingRepoEloquentInterface $settingRepo): void
    {
        $this->app->booted(function () use ($cartRepo, $menuRepo, $productCategoryRepo, $settingRepo) {
            $this->setMenuForPanel();
            $this->sendVarsToViews($cartRepo, $menuRepo, $productCategoryRepo, $settingRepo);
        });
    }

    /**
     * Load home view files.
     *
     * @return void
     */
    private function loadViewFiles(): void
    {
        $this->loadViewsFrom(__DIR__ . $this->viewPath, $this->name);
    }

    /**
     * Load home route files.
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
     * Set menu for home.
     *
     * @return void
     */
    private function setMenuForPanel(): void
    {
        config()->set('panelConfig.menus.home', [
            'title' => 'فروشگاه',
            'icon' => 'fa-store',
//            'url' => route('customer.home'),
        ]);
    }

    /**
     * @param $cartRepo
     * @param $menuRepo
     * @param $productCategoryRepo
     * @param $settingRepo
     * @return void
     */
    private function sendVarsToViews($cartRepo, $menuRepo, $productCategoryRepo, $settingRepo)
    {
        view()->composer('Home::layouts.header', function ($view) use ($cartRepo, $menuRepo, $productCategoryRepo, $settingRepo) {
            if (Auth::check()) {
                $view->with('cartItems', $cartRepo->findUserCartItems()->get());
            }
            $view->with('menus', $menuRepo->getActiveParentMenus()->get());
            $view->with('categories', $productCategoryRepo->getShowInMenuActiveParentCategories()->get());
            $view->with('logo', $settingRepo->findSystemLogo());
        });
    }

    /**
     * @return void
     */
    private function bindRepository(): void
    {
        $this->app->bind(HomeRepoEloquentInterface::class, HomeRepoEloquent::class);
    }
}

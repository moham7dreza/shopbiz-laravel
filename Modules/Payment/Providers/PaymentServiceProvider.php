<?php

namespace Modules\Payment\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Modules\Payment\Entities\Payment;
use Modules\Payment\Policies\PaymentPolicy;
use Modules\Payment\Repositories\PaymentRepoEloquent;
use Modules\Payment\Repositories\PaymentRepoEloquentInterface;
use Modules\Payment\Services\PaymentService;
use Modules\Payment\Services\PaymentServiceInterface;

class PaymentServiceProvider extends ServiceProvider
{
    /**
     * Get namespace for payment controller.
     *
     * @var string
     */
    public string $namespace = 'Modules\Payment\Http\Controllers';

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
    public string $name = 'Payment';

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
    public string $routePath = '/../Routes/payment_routes.php';
    public string $apiRoutePath = '/../Routes/payment_api_routes.php';

    /**
     * Register payment files.
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
        $this->bindService();
    }

    /**
     * Boot payment service provider.
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
     * Load payment migration files.
     *
     * @return void
     */
    private function loadMigrationFiles(): void
    {
        $this->loadMigrationsFrom(__DIR__ . $this->migrationPath);
    }

    /**
     * Load payment view files.
     *
     * @return void
     */
    private function loadViewFiles(): void
    {
        $this->loadViewsFrom(__DIR__ . $this->viewPath, $this->name);
    }

    /**
     * Load payment route files.
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
     * Load payment policy files.
     *
     * @return void
     */
    private function loadPolicyFiles(): void
    {
        Gate::policy(Payment::class, PaymentPolicy::class);
    }

    /**
     * Set menu for payment.
     *
     * @return void
     */
    private function setMenuForPanel(): void
    {
        config()->set('panelConfig.menus.market.payments', [
            'title' => 'پرداخت ها',
            'icon' => 'fa-cash-register',
//            'url' => route('payment.index'),
        ]);
    }

    /**
     * @return void
     */
    private function bindRepository(): void
    {
        $this->app->bind(PaymentRepoEloquentInterface::class, PaymentRepoEloquent::class);
    }

    /**
     * @return void
     */
    private function bindService(): void
    {
        $this->app->bind(PaymentServiceInterface::class, PaymentService::class);
    }
}

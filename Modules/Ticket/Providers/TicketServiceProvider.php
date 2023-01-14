<?php

namespace Modules\Ticket\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Modules\Ticket\Entities\Ticket;
use Modules\Ticket\Policies\TicketPolicy;
use Modules\Ticket\Repositories\Ticket\TicketRepoEloquent;
use Modules\Ticket\Repositories\Ticket\TicketRepoEloquentInterface;
use Modules\Ticket\Repositories\TicketAdmin\TicketAdminRepoEloquent;
use Modules\Ticket\Repositories\TicketAdmin\TicketAdminRepoEloquentInterface;
use Modules\Ticket\Repositories\TicketCategory\TicketCategoryRepoEloquent;
use Modules\Ticket\Repositories\TicketCategory\TicketCategoryRepoEloquentInterface;
use Modules\Ticket\Repositories\TicketPriority\TicketPriorityRepoEloquent;
use Modules\Ticket\Repositories\TicketPriority\TicketPriorityRepoEloquentInterface;
use Modules\Ticket\Services\Ticket\TicketService;
use Modules\Ticket\Services\Ticket\TicketServiceInterface;
use Modules\Ticket\Services\TicketAdmin\TicketAdminService;
use Modules\Ticket\Services\TicketAdmin\TicketAdminServiceInterface;
use Modules\Ticket\Services\TicketCategory\TicketCategoryService;
use Modules\Ticket\Services\TicketCategory\TicketCategoryServiceInterface;
use Modules\Ticket\Services\TicketPriority\TicketPriorityService;
use Modules\Ticket\Services\TicketPriority\TicketPriorityServiceInterface;

class TicketServiceProvider extends ServiceProvider
{
    /**
     * Get namespace for panel controller.
     *
     * @var string
     */
    public string $namespace = 'Modules\Ticket\Http\Controllers';

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
    public string $name = 'Ticket';

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
    public string $routePath = '/../Routes/ticket_routes.php';

    /**
     * Register panel files.
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
     * Boot panel service provider.
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
     * Load panel view files.
     *
     * @return void
     */
    private function loadViewFiles(): void
    {
        $this->loadViewsFrom(__DIR__ . $this->viewPath, $this->name);
    }

    /**
     * Load panel route files.
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
     * Load panel policy files.
     *
     * @return void
     */
    private function loadPolicyFiles(): void
    {
        Gate::policy(Ticket::class, TicketPolicy::class);
    }

    /**
     * Set menu for panel.
     *
     * @return void
     */
    private function setMenuForPanel(): void
    {
        config()->set('panelConfig.menus.tickets.all', [
            'title' => 'تیکت ها',
            'icon' => 'fa-ticket-alt',
            'url' => route('panel.home'),
        ]);
    }

    /**
     * @return void
     */
    private function bindRepository()
    {
        $this->app->bind(TicketRepoEloquentInterface::class, TicketRepoEloquent::class);
        $this->app->bind(TicketAdminRepoEloquentInterface::class, TicketAdminRepoEloquent::class);
        $this->app->bind(TicketCategoryRepoEloquentInterface::class, TicketCategoryRepoEloquent::class);
        $this->app->bind(TicketPriorityRepoEloquentInterface::class, TicketPriorityRepoEloquent::class);
    }

    /**
     * @return void
     */
    private function bindServices()
    {
        $this->app->bind(TicketServiceInterface::class, TicketService::class);
        $this->app->bind(TicketAdminServiceInterface::class, TicketAdminService::class);
        $this->app->bind(TicketCategoryServiceInterface::class, TicketCategoryService::class);
        $this->app->bind(TicketPriorityServiceInterface::class, TicketPriorityService::class);
    }
}

<?php

namespace Modules\Notify\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Modules\Notify\Entities\Email;
use Modules\Notify\Policies\NotifyPolicy;
use Modules\Notify\Repositories\Email\EmailRepoEloquent;
use Modules\Notify\Repositories\Email\EmailRepoEloquentInterface;
use Modules\Notify\Repositories\EmailFile\EmailFileRepoEloquent;
use Modules\Notify\Repositories\EmailFile\EmailFileRepoEloquentInterface;
use Modules\Notify\Repositories\Notification\NotificationRepoEloquent;
use Modules\Notify\Repositories\Notification\NotificationRepoEloquentInterface;
use Modules\Notify\Repositories\SMS\SMSRepoEloquent;
use Modules\Notify\Repositories\SMS\SMSRepoEloquentInterface;
use Modules\Notify\Services\Email\EmailService;
use Modules\Notify\Services\Email\EmailServiceInterface;
use Modules\Notify\Services\EmailFile\EmailFileService;
use Modules\Notify\Services\EmailFile\EmailFileServiceInterface;
use Modules\Notify\Services\Notification\NotificationService;
use Modules\Notify\Services\Notification\NotificationServiceInterface;
use Modules\Notify\Services\SMS\SMSService;
use Modules\Notify\Services\SMS\SMSServiceInterface;

class NotifyServiceProvider extends ServiceProvider
{
    /**
     * Get namespace for panel controller.
     *
     * @var string
     */
    public string $namespace = 'Modules\Notify\Http\Controllers';

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
    public string $name = 'Notify';

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
    public string $routePath = '/../Routes/notify_routes.php';

    /**
     * Register panel files.
     *
     * @return void
     */
    public function register(): void
    {
        $this->loadViewFiles();
        $this->loadRouteFiles();
        $this->loadPolicyFiles();
        $this->bindRepository();
        $this->bindServices();
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
        Gate::policy(Email::class, NotifyPolicy::class);
    }

    /**
     * Set menu for panel.
     *
     * @return void
     */
    private function setMenuForPanel(): void
    {
        config()->set('panelConfig.menus.notify.email', [
            'title' => 'اطلاعیه',
            'icon' => 'fa-mail-bulk',
            'url' => route('email.index'),
        ]);
    }

    /**
     * @return void
     */
    private function bindRepository(): void
    {
        $this->app->bind(EmailRepoEloquentInterface::class, EmailRepoEloquent::class);
        $this->app->bind(SMSRepoEloquentInterface::class, SMSRepoEloquent::class);
        $this->app->bind(EmailFileRepoEloquentInterface::class, EmailFileRepoEloquent::class);
        $this->app->bind(NotificationRepoEloquentInterface::class, NotificationRepoEloquent::class);
    }

    /**
     * @return void
     */
    private function bindServices(): void
    {
        $this->app->bind(EmailServiceInterface::class, EmailService::class);
        $this->app->bind(SMSServiceInterface::class, SMSService::class);
        $this->app->bind(EmailFileServiceInterface::class, EmailFileService::class);
        $this->app->bind(NotificationServiceInterface::class, NotificationService::class);
    }
}

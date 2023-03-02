<?php

namespace Modules\User\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\User\Events\SendEmailToUserEvent;
use Modules\User\Listeners\SendEmailToUserListener;
use Modules\User\Listeners\SendSmsToUserListener;

class EventServiceProvider extends ServiceProvider
{
    /**
     * @var array[]
     */
    protected $listen = [
        SendEmailToUserEvent::class => [
            SendEmailToUserListener::class,
            SendSmsToUserListener::class,
        ],
    ];
}

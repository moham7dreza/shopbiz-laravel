<?php

namespace Modules\User\Listeners;

use Illuminate\Support\Facades\Mail;
use Modules\User\Jobs\SendEmailToUserJob;
use Modules\User\Mail\SendEmailToUserMail;
use Modules\User\Repositories\UserRepoEloquentInterface;

class SendEmailToUserListener
{
    public UserRepoEloquentInterface $userRepoEloquent;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(UserRepoEloquentInterface $userRepoEloquent)
    {
        $this->userRepoEloquent = $userRepoEloquent;
    }

    /**
     * Handle the event.
     *
     * @param object $event
     * @return void
     */
    public function handle(object $event): void
    {
//        $email = new SendEmailToUserMail();
//        Mail::to($event->email)->send($email);
        foreach ($this->userRepoEloquent->customerUsers()->get() as $user) {
            if (!is_null($user->email)) {
                dispatch(new SendEmailToUserJob($user->email, $event->model));
            }
        }

    }
}

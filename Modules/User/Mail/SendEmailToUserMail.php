<?php

namespace Modules\User\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use function Symfony\Component\Translation\t;

class SendEmailToUserMail extends Mailable
{
    use Queueable, SerializesModels;

    public ?Model $model;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($model = null)
    {
        $this->model = $model;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): static
    {
        return $this->markdown('User::mail.send-email-to-user-mail');
    }
}

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
    public ?string $mailSubject;
    public ?string $mailMessage;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($model = null, $mailSubject = null, $mailMessage = null)
    {
        $this->model = $model;
        $this->mailSubject = $mailSubject;
        $this->mailMessage = $mailMessage;
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

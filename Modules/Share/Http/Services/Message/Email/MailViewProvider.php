<?php

namespace Modules\Share\Http\Services\Message\Email;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailViewProvider extends Mailable
{
    use Queueable, SerializesModels;

    public $details;

    /**
     * @param $details
     * @param $subject
     * @param $from
     */
    public function __construct($details, $subject, $from)
    {
        $this->details = $details;
        $this->subject = $subject;
        $this->from = $from;
    }

    /**
     * @return MailViewProvider
     */
    public function build(): MailViewProvider
    {
        return $this->subject($this->subject)->view('emails.send-otp');
    }
}

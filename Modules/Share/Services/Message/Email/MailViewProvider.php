<?php

namespace Modules\Share\Services\Message\Email;

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
        return $this->subject($this->subject)->view('Share::emails.send-otp');
    }
}

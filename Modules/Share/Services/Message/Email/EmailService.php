<?php

namespace Modules\Share\Services\Message\Email;

use Illuminate\Support\Facades\Mail;
use Modules\Notify\Http\Interfaces\MessageInterface;


class EmailService implements MessageInterface
{

    private $details;
    private $subject;
    /**
     * @var array[]
     */
    private array $from = [
        ['address' => null, 'name' => null,]
    ];
    private $to;

    /**
     * @return true
     */
    public function fire(): true
    {
        Mail::to($this->to)->send(new MailViewProvider($this->details, $this->subject, $this->from));
        return true;
    }

    /**
     * @return mixed
     */
    public function getDetails(): mixed
    {
        return $this->details;
    }

    /**
     * @param $details
     * @return void
     */
    public function setDetails($details): void
    {
        $this->details = $details;
    }


    /**
     * @return mixed
     */
    public function getSubject(): mixed
    {
        return $this->subject;
    }

    /**
     * @param $subject
     * @return void
     */
    public function setSubject($subject): void
    {
        $this->subject = $subject;
    }


    /**
     * @return array[]
     */
    public function getFrom(): array
    {
        return $this->from;
    }

    /**
     * @param $address
     * @param $name
     * @return void
     */
    public function setFrom($address, $name): void
    {
        $this->from = [
            [
                'address' => $address,
                'name' => $name,
            ]
        ];
    }

    /**
     * @return mixed
     */
    public function getTo(): mixed
    {
        return $this->to;
    }

    /**
     * @param $to
     * @return void
     */
    public function setTo($to): void
    {
        $this->to = $to;
    }
}

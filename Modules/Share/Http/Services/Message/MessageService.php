<?php

namespace Modules\Share\Http\Services\Message;

use Modules\Notify\Http\Interfaces\MessageInterface;

class MessageService
{
    private $message;

    public function __construct(MessageInterface $message)
    {
        $this->message = $message;
    }

    public function send(){
        return $this->message->fire();
    }
}

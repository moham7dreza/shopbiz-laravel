<?php

namespace Modules\Share\Http\Services\Message\SMS;

use Modules\Notify\Http\Interfaces\MessageInterface;

class SmsService implements MessageInterface
{

    private $from;
    private $text;
    private $to;
    private $isFlash = true;

    /**
     * @return bool|null
     */
    public function fire(): ?bool
    {
        $meliPayamak = new MeliPayamakService();
        return $meliPayamak->sendSmsSoapClient($this->from, $this->to, $this->text, $this->isFlash);
    }

    /**
     * @return mixed
     */
    public function getFrom(): mixed
    {
        return $this->from;
    }

    /**
     * @param $from
     * @return void
     */
    public function setFrom($from): void
    {
        $this->from = $from;
    }


    /**
     * @return mixed
     */
    public function getText(): mixed
    {
        return $this->text;
    }

    /**
     * @param $text
     * @return void
     */
    public function setText($text): void
    {
        $this->text = $text;
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

    /**
     * @return mixed
     */
    public function getIsFlash(): mixed
    {
        return $this->to;
    }

    /**
     * @param $flash
     * @return void
     */
    public function setIsFlash($flash): void
    {
        $this->isFlash = $flash;
    }
}

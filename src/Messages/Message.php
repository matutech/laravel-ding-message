<?php


namespace Matu\Ding\Messages;


abstract class Message
{
    protected $message = [];


    public function getMessage()
    {
        return $this->message;
    }



    public function getBody()
    {

        return $this->message;
    }
}

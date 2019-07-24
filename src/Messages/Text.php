<?php


namespace Matu\Ding\Messages;


class Text extends Message
{
    public function __construct($content)
    {
        $this->message = [
            'msgtype' => 'text',
            'text'    => [
                "content"=> $content
            ]
        ];
    }
}

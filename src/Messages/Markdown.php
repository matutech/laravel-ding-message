<?php


namespace Matu\Ding\Messages;


class Markdown extends Message
{
    public function __construct($title, $content)
    {
        $this->message = [
            'msgtype'  => 'markdown',
            'markdown' => [
                "title" => $title,
                "text"  => $content
            ]
        ];
    }
}

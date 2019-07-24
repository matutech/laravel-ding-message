<?php

use Matu\Ding\SendMessage;
if (!function_exists('dingMsg')) {
    function dingMsg()
    {
        $arguments = func_get_args();

        $dingTalk = app(SendMessage::class);

        if (empty($arguments)) {
            return $dingTalk;
        }

        if (is_string($arguments[0])) {
            return $dingTalk->text($arguments[0]);
        }
    }
};

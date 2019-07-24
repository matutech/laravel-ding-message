<?php


namespace Matu\Ding;


use Matu\Ding\Service\AccessTokenService;
use Matu\Ding\service\SendMessageService;

class SendMessage
{
    protected $token;

    protected $client;
    /**
     * @var array
     */
    protected $mobiles = [];
    /**
     * @var bool
     */
    protected $atAll = false;

    protected $sendMessageService;

    public function __construct()
    {

        $this->sendMessageService = $this->create();
    }

    /**
     * @return SendMessageService
     */
    public function create()
    {
        return new SendMessageService(new AccessTokenService());
    }

    public function text(string $content = '')
    {
        return $this->sendMessageService->setTextMessage($content)->send();
    }

    public function markdown(string $title = '', string $content = '')
    {
        return $this->sendMessageService->setMarkdownMessage($title, $content)->send();
    }
}

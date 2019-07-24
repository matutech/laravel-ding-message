<?php


namespace Matu\Ding\service;


use GuzzleHttp\Exception\RequestException;
use Matu\Ding\Messages\Markdown;
use Matu\Ding\Messages\Text;
use Matu\Ding\Models\DingGroup;

class SendMessageService
{

    /**
     * @var array
     */
    protected $mobiles = [];
    /**
     * @var bool
     */
    protected $atAll = false;

    protected $message;

    protected $token;

    protected $client;

    public function __construct(AccessTokenService $tokenService)
    {
        $this->token  = $tokenService->getToken();
        $this->client = $tokenService->createClient();
        $this->setTextMessage(null);
    }

    public function setMessage($message)
    {
        $this->message = $message;
    }

    public function getMessage()
    {
        return $this->message->getMessage();
    }


    /**
     * 设置文本消息
     *
     * @param $content
     * @return $this
     */
    public function setTextMessage($content)
    {
        $this->message = new Text($content);

        return $this;
    }


    /**
     * 设置 markdown 消息
     *
     * @param $title
     * @param $content
     * @return $this
     */
    public function setMarkdownMessage($title, $content)
    {
        $this->message = new Markdown($title, $content);

        return $this;
    }

    /**
     * 发送消息
     *
     * @throws \Exception
     */
    public function send()
    {
        if (!config('mt-ding.enabled')){
            return true;
        }
        // 获取发送消息群
        $group = DingGroup::where('is_send', 1)->first();
        if (!$group) {
            throw new \Exception('未找到可以发送消息的群');
        }
        try {
            $response = $this->client->post('/chat/send', [
                'query' => [
                    'access_token' => $this->token
                ],
                'json'  => [
                    'chatid' => $group->chatid,
                    'msg'    => $this->message->getBody()
                ],
            ]);

            $body = json_decode($response->getBody()->getContents());

            if ($body->errcode !== 0) {
                throw new \Exception($body->errmsg);
            }
        } catch (RequestException $e) {
            throw new \Exception($e->getMessage());
        }


    }
}

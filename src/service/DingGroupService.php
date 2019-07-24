<?php


namespace Matu\Ding\Service;


use GuzzleHttp\Exception\RequestException;
use Matu\Ding\Models\DingGroup;

class DingGroupService
{
    protected $token;

    protected $client;

    /**
     * DingGroup constructor.
     * @param AccessTokenService $accessToken
     * @throws \Exception
     */
    public function __construct(AccessTokenService $accessToken)
    {
        $this->token  = $accessToken->getToken();
        $this->client = $accessToken->createClient();
    }


    /**
     * 创建群会话
     *
     * @param string $name
     * @param string $owner
     * @param array $userIdList
     * @return string
     * @throws \Exception
     */
    public function createChat(string $name, string $owner)
    {
        try {

            $response = $this->client->post(config('mt-ding.host') . '/chat/create', [
                'query' => [
                    'access_token' => $this->token
                ],
                'json'  => [
                    'name'       => $name,
                    'owner'      => $owner,
                    'useridlist' => [$owner]
                ]
            ]);

            $body = json_decode($response->getBody()->getContents());

            DingGroup::query()->updateOrCreate([
                'chatid' => $body->chatid
            ], [
                'name'                 => $name,
                'open_conversation_id' => $body->openConversationId,
                'conversation_tag'     => $body->conversationTag
            ]);

        } catch (RequestException $e) {
            throw new \Exception('网络请求失败');
        }
    }


}

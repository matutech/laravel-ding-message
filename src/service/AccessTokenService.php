<?php


namespace Matu\Ding\Service;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class AccessTokenService
{
    protected $client;


    protected $cacheName;

    public function __construct()
    {

        $this->client    = $this->createClient();
        $this->cacheName = config('mt-ding.cache_name');
    }


    /**
     * 获取钉钉 token
     *
     * @return mixed
     * @throws \Exception
     */
    public function getToken()
    {

        // 从缓存中获取 钉钉 accessToken
        if (\Cache::has($this->cacheName)) {
            return \Cache::get($this->cacheName);
        } else {
            return $this->getDingToken();
        }
    }

    /**
     * 获取钉钉 access token
     *
     * @return mixed
     * @throws \Exception
     */
    protected function getDingToken()
    {
        try {

            $response = $this->client->get(config('mt-ding.host') . '/gettoken', [
                'query' => [
                    'appkey'    => config('mt-ding.app_key'),
                    'appsecret' => config('mt-ding.app_secret')
                ]
            ]);

            $code = $response->getStatusCode();
            // 判断 http 状态码
            if ($code != 200) {
                throw new \Exception('网络请求失败');
            }
            $body = json_decode($response->getBody()->getContents());
            // 判断请求结果
            if ($body->errcode !== 0) {
                throw new \Exception($body->errmsg);
            } else {
                \Cache::put(config('mt-ding.cache_name'), $body->access_token, 120);

                return $body->access_token;
            }

        } catch (RequestException $e) {
            throw new \Exception('网络请求失败');
        }
    }

    /**
     * 创建连接客户端
     *
     * @return Client
     */
    public function createClient()
    {
        $client = new Client([
            'base_uri' =>config('mt-ding.host'),
            'timeout' => config('mt-ding.timeout') ?? 2.0,
        ]);

        return $client;
    }
}

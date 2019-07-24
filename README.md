# 码途钉钉群消息通知

## 环境

- PHP 版本：PHP >= 7.0
- Laravel：5.8 +

## 安装

`composer require matu/laravel-ding`

## 发布配置文件

` php artisan vendor:publish --provider="Matu\Ding\DingServiceProvider"`

## 配置文件

配置文件在 config 目录下 mt-ding.php

```php
    // 默认开启发送
    'enabled'    => env('DING_ENABLED', true),
    // 钉钉 agent id
    'agent_id'   => env('DING_AGENT_ID', ''),
    // 钉钉 应用的唯一标识key
    'app_key'    => env('DING_APP_KEY', ''),
    // 钉钉 应用的秘钥
    'app_secret' => env('DING_APP_SECRET', ''),
    // 钉钉缓存秘钥名称
    'cache_name' => env('DING_CACHE_NAME', 'ding_cache_access_token'),
    // 钉钉请求地址
    'host'       => env('DING_HOST', ''),
    // 钉钉请求的超时时间
    'timeout'    => env('DING_TIME_OUT', 2.0),
```


## 初始化

1. 更新部门数据
2. 获取部门下用户
3. 创建群
4. 设置需要发送的群

## 命令行使用

- 查看、更新部门： `php artisan ding:department`
- 查看、获取用户： `php artisan ding:user`
- 查看、创建群组： `php artisan ding:group`
- 设置发送的群：   `php artisan ding:setting`

## 使用

1. 发送文本消息： `dingMsg('这是一段文字');`
2. 发送 markdown 消息： `dingMsg()->markdown('标题','# 内容');`

<?php

return [
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
];

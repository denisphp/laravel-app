<?php

return [
    /*
    |--------------------------------------------------------------------------
    | JWT time to live
    |--------------------------------------------------------------------------
    |
    | Specify the length of time (in seconds) that the API token will be valid for.
    |
    |
    */

    'api_ttl' => 86400,

    /*
    |--------------------------------------------------------------------------
    | JWT time to live
    |--------------------------------------------------------------------------
    |
    | Specify the Redis API session key prefix.
    |
    |
    */

    'redis_api_session_key_prefix' => 'session::',
];

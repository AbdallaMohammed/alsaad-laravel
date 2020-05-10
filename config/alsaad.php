<?php

return [

    /*
    |--------------------------------------------------------------------------
    | API Credentials
    |--------------------------------------------------------------------------
    |
    | If you're using API credentials, change these settings.
    |
    */
    'username' => function_exists('env') ? env('ALSAAD_USERNAME', '') : '',
    'password' => function_exists('env') ? env('ALSAAD_PASSWORD', '') : '',

    /*
    |--------------------------------------------------------------------------
    | Client Override
    |--------------------------------------------------------------------------
    |
    | In the event you need to use this with nexmo/client-core, this can be set
    | to provide a custom HTTP client.
    |
    */
    'http_client' => function_exists('env') ? env('ALSAAD_HTTP_CLIENT', '') : '',
];

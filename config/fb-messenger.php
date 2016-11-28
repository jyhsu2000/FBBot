<?php

return [
    'debug'        => env('MESSENGER_DEBUG', false),
    'verify_token' => env('MESSENGER_VERIFY_TOKEN'),
    'app_token'    => env('MESSENGER_APP_TOKEN'),
    'auto_typing'  => true,
    'handlers'     => [
        Casperlaitw\LaravelFbMessenger\Contracts\DefaultHandler::class,
    ],
    'custom_url'   => '/webhook',
    'postbacks'    => [
        App\PostbackHandlers\MenuPostback::class,
        App\PostbackHandlers\ChallengePostback::class,
        App\PostbackHandlers\TalkPostback::class,
    ],
];

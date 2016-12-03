<?php

return [
    'debug'        => env('MESSENGER_DEBUG', false),
    'verify_token' => env('MESSENGER_VERIFY_TOKEN'),
    'app_token'    => env('MESSENGER_APP_TOKEN'),
    'auto_typing'  => false,
    'handlers'     => [
        App\Chatbot\MessageHandlers\DefaultHandler::class,
    ],
    'custom_url'   => '/webhook',
    'postbacks'    => [
        App\Chatbot\PostbackHandlers\MenuPostback::class,
        App\Chatbot\PostbackHandlers\ChallengePostback::class,
        App\Chatbot\PostbackHandlers\TalkPostback::class,
        App\Chatbot\PostbackHandlers\DefaultPostbackHandler::class,
    ],
];

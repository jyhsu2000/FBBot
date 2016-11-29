<?php

namespace App\Chatbot\PostbackHandlers;

use App\Chatbot\Tasks\MenuTask;
use Casperlaitw\LaravelFbMessenger\Contracts\PostbackHandler;
use Casperlaitw\LaravelFbMessenger\Messages\ReceiveMessage;

class MenuPostback extends PostbackHandler
{
    // If webhook get the $payload is `USER_DEFINED_PAYLOAD` will run this postback handler
    protected $payload = 'MENU'; // You also can use regex!

    /**
     * Handle the chatbot message
     *
     * @param ReceiveMessage $message
     *
     * @return mixed
     */
    public function handle(ReceiveMessage $message)
    {
        app(MenuTask::class)->run($this, $message);
    }
}

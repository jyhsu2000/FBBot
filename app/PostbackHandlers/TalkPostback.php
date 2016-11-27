<?php

namespace App\PostbackHandlers;

use Casperlaitw\LaravelFbMessenger\Contracts\PostbackHandler;
use Casperlaitw\LaravelFbMessenger\Messages\QuickReply;
use Casperlaitw\LaravelFbMessenger\Messages\ReceiveMessage;
use Casperlaitw\LaravelFbMessenger\Messages\Text;

class TalkPostback extends PostbackHandler
{
    // If webhook get the $payload is `USER_DEFINED_PAYLOAD` will run this postback handler
    protected $payload = 'TALK'; // You also can use regex!

    /**
     * Handle the chatbot message
     *
     * @param ReceiveMessage $message
     *
     * @return mixed
     */
    public function handle(ReceiveMessage $message)
    {
        //TODO
        $text = new Text($message->getSender(), "我該說什麼？");
        $this->send($text);
    }
}

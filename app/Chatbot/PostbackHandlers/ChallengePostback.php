<?php

namespace App\Chatbot\PostbackHandlers;

use Casperlaitw\LaravelFbMessenger\Contracts\PostbackHandler;
use Casperlaitw\LaravelFbMessenger\Messages\QuickReply;
use Casperlaitw\LaravelFbMessenger\Messages\ReceiveMessage;
use Casperlaitw\LaravelFbMessenger\Messages\Text;

class ChallengePostback extends PostbackHandler
{
    // If webhook get the $payload is `USER_DEFINED_PAYLOAD` will run this postback handler
    protected $payload = 'CHALLENGE'; // You also can use regex!

    /**
     * Handle the chatbot message
     *
     * @param ReceiveMessage $message
     *
     * @return mixed
     */
    public function handle(ReceiveMessage $message)
    {
        $testJson = [
            'test' => 'TT',
            2      => [
                1,
                2,
            ],
        ];
        //TODO
        $text = new Text($message->getSender(), '施工中...期待嗎？');
        $text->addQuick(new QuickReply('期待', 'EXPECT'))
            ->addQuick(new QuickReply('不期待', 'NO_EXPECT'))
            ->addQuick(new QuickReply('JSON', 'JSON ' . json_encode($testJson)));
        $this->send($text);
    }
}

<?php

namespace App\Chatbot\Postbacks;

use Casperlaitw\LaravelFbMessenger\Messages\Text;
use Casperlaitw\LaravelFbMessenger\Contracts\BaseHandler;
use Casperlaitw\LaravelFbMessenger\Messages\ReceiveMessage;

class TalkPostback extends Postback
{
    /* @var string 對應的關鍵字 */
    public $keyword = 'TALK';

    /**
     * 執行
     *
     * @param BaseHandler $handler
     * @param ReceiveMessage $receiveMessage
     * @return mixed
     */
    public function run(BaseHandler $handler, ReceiveMessage $receiveMessage)
    {
        $text = new Text($receiveMessage->getSender(), '我該說什麼？');
        $handler->send($text);
    }
}

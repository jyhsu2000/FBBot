<?php

namespace App\Chatbot\Tasks;

use App\Quotation;
use Casperlaitw\LaravelFbMessenger\Messages\Text;
use Casperlaitw\LaravelFbMessenger\Contracts\BaseHandler;
use Casperlaitw\LaravelFbMessenger\Messages\ReceiveMessage;

class TalkTask extends Task
{
    /**
     * 說點什麼
     *
     * @param BaseHandler $handler
     * @param ReceiveMessage $receiveMessage
     * @return mixed
     */
    public function saySomething(BaseHandler $handler, ReceiveMessage $receiveMessage)
    {
        $message = '我該說什麼？';
        $quotation = Quotation::inRandomOrder()->first();
        if ($quotation) {
            $message = $quotation->content;
            $quotation->increment('counter');
        }
        $text = new Text($receiveMessage->getSender(), $message);
        $handler->send($text);
    }
}

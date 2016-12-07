<?php

namespace App\Chatbot\Tasks;

use Casperlaitw\LaravelFbMessenger\Contracts\BaseHandler;
use Casperlaitw\LaravelFbMessenger\Messages\QuickReply;
use Casperlaitw\LaravelFbMessenger\Messages\ReceiveMessage;
use Casperlaitw\LaravelFbMessenger\Messages\Text;

class NidTask extends Task
{
    /**
     * 執行任務
     *
     * @param BaseHandler $handler
     * @param ReceiveMessage $receiveMessage
     * @return mixed
     */
    public function run(BaseHandler $handler, ReceiveMessage $receiveMessage)
    {
        //
    }

    /**
     * 要求輸入
     *
     * @param BaseHandler $handler
     * @param ReceiveMessage $receiveMessage
     * @return mixed
     */
    public function askForInput(BaseHandler $handler, ReceiveMessage $receiveMessage)
    {
        $text = new Text($receiveMessage->getSender(), '請輸入NID');
        $text->addQuick(new QuickReply('取消輸入', 'CHALLENGE ' . json_encode(['action' => 'CANCEL_BIND_NID'])));
        $handler->send($text);
    }
}

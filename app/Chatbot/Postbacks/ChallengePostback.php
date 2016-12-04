<?php

namespace App\Chatbot\Postbacks;

use Casperlaitw\LaravelFbMessenger\Messages\Text;
use Casperlaitw\LaravelFbMessenger\Messages\QuickReply;
use Casperlaitw\LaravelFbMessenger\Contracts\BaseHandler;
use Casperlaitw\LaravelFbMessenger\Messages\ReceiveMessage;

class ChallengePostback extends Postback
{
    /* @var string 對應的關鍵字 */
    public $keyword = 'CHALLENGE';

    /**
     * 執行
     *
     * @param BaseHandler $handler
     * @param ReceiveMessage $receiveMessage
     * @return mixed
     */
    public function run(BaseHandler $handler, ReceiveMessage $receiveMessage)
    {
        $text = new Text($receiveMessage->getSender(), '施工中...期待嗎？');
        $text->addQuick(new QuickReply('期待', 'EXPECT'))
            ->addQuick(new QuickReply('不期待', 'NO_EXPECT'));
        $handler->send($text);
    }
}

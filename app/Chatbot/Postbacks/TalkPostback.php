<?php

namespace App\Chatbot\Postbacks;

use App\Chatbot\Tasks\TalkTask;
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
        app(TalkTask::class)->saySomething($handler, $receiveMessage);
    }
}

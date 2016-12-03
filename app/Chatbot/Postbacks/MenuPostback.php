<?php

namespace App\Chatbot\Postbacks;

use App\Chatbot\Tasks\MenuTask;
use Casperlaitw\LaravelFbMessenger\Contracts\BaseHandler;
use Casperlaitw\LaravelFbMessenger\Messages\ReceiveMessage;

class MenuPostback extends Postback
{
    /* @var string 對應的關鍵字 */
    public $keyword = 'MENU';

    /**
     * 執行
     *
     * @param BaseHandler $handler
     * @param ReceiveMessage $receiveMessage
     * @return mixed
     */
    public function run(BaseHandler $handler, ReceiveMessage $receiveMessage)
    {
        app(MenuTask::class)->run($handler, $receiveMessage);
    }
}

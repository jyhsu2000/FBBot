<?php

namespace App\Chatbot\Commands;

use App\Chatbot\Tasks\MenuTask;
use Casperlaitw\LaravelFbMessenger\Contracts\BaseHandler;
use Casperlaitw\LaravelFbMessenger\Messages\ReceiveMessage;

class MenuCommand extends Command
{
    /* @var array 對應指令清單 */
    public $commands = ['menu'];
    /* @var string 指令描述 */
    public $description = '顯示選單';

    /**
     * 執行指令
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

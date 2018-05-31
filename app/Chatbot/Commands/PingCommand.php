<?php

namespace App\Chatbot\Commands;

use Casperlaitw\LaravelFbMessenger\Contracts\BaseHandler;
use Casperlaitw\LaravelFbMessenger\Messages\ReceiveMessage;
use Casperlaitw\LaravelFbMessenger\Messages\Text;

class PingCommand extends Command
{
    /* @var array 對應指令清單 */
    public $commands = ['ping'];
    /* @var string 指令描述 */
    public $description = 'Ping!';

    /**
     * 執行指令
     *
     * @param BaseHandler $handler
     * @param ReceiveMessage $receiveMessage
     * @return mixed
     */
    public function run(BaseHandler $handler, ReceiveMessage $receiveMessage)
    {
        $handler->send(new Text($receiveMessage->getSender(), 'Pong!'));
    }
}

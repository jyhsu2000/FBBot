<?php

namespace App\Chatbot\Commands;

use Casperlaitw\LaravelFbMessenger\Contracts\BaseHandler;
use Casperlaitw\LaravelFbMessenger\Messages\ReceiveMessage;
use Casperlaitw\LaravelFbMessenger\Messages\Text;

class HelpCommand extends Command
{
    /* @var array 對應指令清單 */
    public $commands = ['help', '?'];
    /* @var string 指令描述 */
    public $description = '顯示指令清單';

    /**
     * 執行指令
     *
     * @param BaseHandler $handler
     * @param ReceiveMessage $receiveMessage
     * @return mixed
     */
    public function run(BaseHandler $handler, ReceiveMessage $receiveMessage)
    {
        $message = '指令清單：';
        $kernelObject = app(Kernel::class);
        foreach ($kernelObject->commandClasses as $commandClass) {
            $commandObject = app($commandClass);
            $message .= PHP_EOL . $commandObject->commands[0] . '：' . $commandObject->description;
        }
        $handler->send(new Text($receiveMessage->getSender(), $message));
    }
}

<?php

namespace App\Chatbot\Commands;

use Casperlaitw\LaravelFbMessenger\Contracts\BaseHandler;
use Casperlaitw\LaravelFbMessenger\Messages\ReceiveMessage;

class CommandKernel
{
    /** @var Command[]|array */
    public $commandClasses = [
        PingCommand::class,
        HelpCommand::class,
        MenuCommand::class,
    ];

    public function run(BaseHandler $handler, ReceiveMessage $receiveMessage)
    {
        //不處理空指令
        if (empty($receiveMessage->getMessage())) {
            return false;
        }
        //逐指令檢查
        /** @var Command $runClass */
        $runClass = null;
        foreach ($this->commandClasses as $commandClass) {
            $classObject = app($commandClass);
            if ($classObject->match($receiveMessage)) {
                $runClass = $commandClass;
                break;
            }
        }
        //無對應指令
        if (!$runClass) {
            return false;
        }
        //執行指令
        app($runClass)->run($handler, $receiveMessage);

        return true;
    }
}

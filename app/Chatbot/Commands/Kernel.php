<?php

namespace App\Chatbot\Commands;

use Casperlaitw\LaravelFbMessenger\Contracts\BaseHandler;
use Casperlaitw\LaravelFbMessenger\Messages\ReceiveMessage;

class Kernel
{
    /** @var Command[]|array */
    public $commandClasses = [
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
        $isMatch = false;
        /** @var Command $runClass */
        $runClass = null;
        foreach ($this->commandClasses as $commandClass) {
            foreach (app($commandClass)->commands as $command) {
                if (strcasecmp($receiveMessage->getMessage(), $command) == 0) {
                    $runClass = $commandClass;
                    $isMatch = true;
                    break;
                }
            }
            if ($isMatch) {
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

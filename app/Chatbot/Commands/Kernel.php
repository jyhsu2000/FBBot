<?php

namespace App\Chatbot\Commands;

use Casperlaitw\LaravelFbMessenger\Contracts\BaseHandler;
use Casperlaitw\LaravelFbMessenger\Messages\ReceiveMessage;

class Kernel
{
    /** @var Command[]|array */
    public static $commandClasses = [
        HelpCommand::class,
    ];

    public static function run(BaseHandler $handler, ReceiveMessage $receiveMessage)
    {
        //不處理空指令
        if (empty($receiveMessage->getMessage())) {
            return false;
        }
        //逐指令檢查
        $isMatch = false;
        /** @var Command $runClass */
        $runClass = null;
        foreach (static::$commandClasses as $commandClass) {
            foreach (with($commandClass)->commands as $command) {
                if ($receiveMessage->getMessage() == $command) {
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
        with($runClass)->run($handler, $receiveMessage);

        return true;
    }
}

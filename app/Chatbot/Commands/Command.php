<?php

namespace App\Chatbot\Commands;

use Casperlaitw\LaravelFbMessenger\Contracts\BaseHandler;
use Casperlaitw\LaravelFbMessenger\Messages\ReceiveMessage;

abstract class Command
{
    /* @var array 對應指令清單 */
    public $commands = [''];
    /* @var string 指令描述 */
    public $description = '';

    /**
     * 執行指令
     *
     * @param BaseHandler $handler
     * @param ReceiveMessage $receiveMessage
     * @return mixed
     */
    abstract public function run(BaseHandler $handler, ReceiveMessage $receiveMessage);

    /**
     * 檢查是否匹配指令
     *
     * @param ReceiveMessage $receiveMessage
     * @return bool
     */
    final public function match(ReceiveMessage $receiveMessage)
    {
        foreach ($this->commands as $command) {
            if (strcasecmp($receiveMessage->getMessage(), $command) == 0) {
                return true;
            }
        }

        return false;
    }
}

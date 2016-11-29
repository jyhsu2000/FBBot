<?php

namespace App\Chatbot\Tasks;

use Casperlaitw\LaravelFbMessenger\Contracts\BaseHandler;
use Casperlaitw\LaravelFbMessenger\Messages\ReceiveMessage;

abstract class Task
{
    /**
     * 執行任務
     *
     * @param BaseHandler $handler
     * @param ReceiveMessage $receiveMessage
     * @return mixed
     */
    abstract public function run(BaseHandler $handler, ReceiveMessage $receiveMessage);
}

<?php

namespace App\Chatbot\Postbacks;

use Casperlaitw\LaravelFbMessenger\Contracts\BaseHandler;
use Casperlaitw\LaravelFbMessenger\Messages\ReceiveMessage;

abstract class Postback
{
    /* @var string 對應的關鍵字 */
    public $keyword = '';

    /**
     * 執行
     *
     * @param BaseHandler $handler
     * @param ReceiveMessage $receiveMessage
     * @return mixed
     */
    abstract public function run(BaseHandler $handler, ReceiveMessage $receiveMessage);

    /**
     * 檢查是否匹配關鍵字
     *
     * @param string $keyword
     * @return bool
     */
    final public function match($keyword)
    {
        if (strcasecmp($keyword, $this->keyword) == 0) {
            return true;
        }

        return false;
    }
}

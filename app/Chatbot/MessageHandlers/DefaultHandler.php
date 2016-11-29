<?php

namespace App\Chatbot\MessageHandlers;

use App\Chatbot\Commands\Kernel;
use Casperlaitw\LaravelFbMessenger\Contracts\BaseHandler;
use Casperlaitw\LaravelFbMessenger\Messages\ReceiveMessage;
use Casperlaitw\LaravelFbMessenger\Messages\Text;

/**
 * Class DefaultHandler
 */
class DefaultHandler extends BaseHandler
{
    /**
     * Handle the chatbot message
     *
     * @param ReceiveMessage $receiveMessage
     *
     * @return mixed
     */
    public function handle(ReceiveMessage $receiveMessage)
    {
        $message = $receiveMessage->getMessage();
        //不處理空白訊息
        //TODO: 需處理貼圖、按讚等附件訊息
        if (empty($message)) {
            return;
        }
        //檢查有無對應指令
        $runSuccess = app(Kernel::class)->run($this, $receiveMessage);
        if ($runSuccess) {
            return;
        }
        //無對應指令
        $this->send(new Text($receiveMessage->getSender(), ' 👤：' . $receiveMessage->getMessage()));
    }
}

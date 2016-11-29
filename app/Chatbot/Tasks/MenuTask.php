<?php

namespace App\Chatbot\Tasks;

use Casperlaitw\LaravelFbMessenger\Contracts\BaseHandler;
use Casperlaitw\LaravelFbMessenger\Messages\GenericTemplate;
use Casperlaitw\LaravelFbMessenger\Messages\ReceiveMessage;

class MenuTask extends Task
{
    /**
     * 執行任務
     *
     * @param BaseHandler $handler
     * @param ReceiveMessage $receiveMessage
     * @return mixed
     */
    public function run(BaseHandler $handler, ReceiveMessage $receiveMessage)
    {
        //顯示選單
        $smallBlackHat = 'http://i.imgur.com/qArK6MG.png';

        $generic = new GenericTemplate($receiveMessage->getSender());
        $generic->addElement('小黑帽向你問好～', '想做什麼呢？', $smallBlackHat)
            ->buttons()
            ->addPostBackButton('🚩資安大挑戰', 'CHALLENGE')
            ->addPostBackButton('👄隨便說點什麼吧', 'TALK')
            ->addWebButton('💻參觀黑客社網站', 'https://hackersir.org/');
        $handler->send($generic);
    }
}

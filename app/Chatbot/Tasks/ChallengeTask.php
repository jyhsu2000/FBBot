<?php

namespace App\Chatbot\Tasks;

use Casperlaitw\LaravelFbMessenger\Contracts\BaseHandler;
use Casperlaitw\LaravelFbMessenger\Messages\ReceiveMessage;
use Casperlaitw\LaravelFbMessenger\Messages\GenericTemplate;

class ChallengeTask extends Task
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
        //
    }

    /**
     * 顯示選單
     *
     * @param BaseHandler $handler
     * @param ReceiveMessage $receiveMessage
     * @return mixed
     */
    public function showMenu(BaseHandler $handler, ReceiveMessage $receiveMessage)
    {
        //顯示選單
        $smallBlackHat = 'http://i.imgur.com/qArK6MG.png';

        $generic = new GenericTemplate($receiveMessage->getSender());
        $generic->addElement('資安大挑戰', '想做什麼呢？', $smallBlackHat)
            ->buttons()
            ->addPostBackButton('📲綁定NID', 'CHALLENGE ' . json_encode(['action' => 'BIND_NID']))
            //TODO: 根據遊玩情況，決定顯示開始挑戰還是繼續挑戰
            ->addPostBackButton('🎮開始挑戰', 'CHALLENGE ' . json_encode(['action' => 'START']))
            //TODO: 根據玩家，連到對應網址
            ->addWebButton('👀查看進度＆記錄', 'https://fbbot.kid7.club/');
        $handler->send($generic);
    }
}

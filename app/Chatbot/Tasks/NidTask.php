<?php

namespace App\Chatbot\Tasks;

use App\Player;
use Casperlaitw\LaravelFbMessenger\Messages\Text;
use Casperlaitw\LaravelFbMessenger\Messages\QuickReply;
use Casperlaitw\LaravelFbMessenger\Contracts\BaseHandler;
use Casperlaitw\LaravelFbMessenger\Messages\ReceiveMessage;

class NidTask extends Task
{
    private static $pattern = '/^(([depmv]([0-9]){7})|(t[0-9]{5}))$/i';

    /**
     * 執行任務
     *
     * @param BaseHandler $handler
     * @param ReceiveMessage $receiveMessage
     * @return mixed
     */
    public function run(BaseHandler $handler, ReceiveMessage $receiveMessage)
    {
        $message = $receiveMessage->getMessage();
        //處理NID
        //檢查NID格式
        if (!preg_match(static::$pattern, $message)) {
            $text = new Text($receiveMessage->getSender(), 'NID格式有誤，請重新輸入');
            $text->addQuick(new QuickReply('取消輸入', 'CHALLENGE ' . json_encode(['action' => 'CANCEL_BIND_NID'])));
            $handler->send($text);

            return;
        }
        $text = new Text($receiveMessage->getSender(), '綁定NID: ' . $message);
        $handler->send($text);
        //清除輸入中的狀態
        $sender = $receiveMessage->getSender();
        $player = Player::findOrCreate($sender);
        $player->update(['state' => '']);
    }

    /**
     * 要求輸入
     *
     * @param BaseHandler $handler
     * @param ReceiveMessage $receiveMessage
     * @return mixed
     */
    public function askForInput(BaseHandler $handler, ReceiveMessage $receiveMessage)
    {
        $text = new Text($receiveMessage->getSender(), '請輸入NID');
        $text->addQuick(new QuickReply('取消輸入', 'CHALLENGE ' . json_encode(['action' => 'CANCEL_BIND_NID'])));
        $handler->send($text);
    }
}
<?php

namespace App\Chatbot\Postbacks;

use App\Player;
use Casperlaitw\LaravelFbMessenger\Messages\Text;
use Casperlaitw\LaravelFbMessenger\Contracts\BaseHandler;
use Casperlaitw\LaravelFbMessenger\Messages\ReceiveMessage;

class ChallengePostback extends Postback
{
    /* @var string 對應的關鍵字 */
    public $keyword = 'CHALLENGE';

    /**
     * 執行
     *
     * @param BaseHandler $handler
     * @param ReceiveMessage $receiveMessage
     * @return mixed
     */
    public function run(BaseHandler $handler, ReceiveMessage $receiveMessage)
    {
        $sender = $receiveMessage->getSender();
        //TODO: 建立或取得玩家
        $player = Player::where('app_uid', $sender)->first();
        if (!$player) {
            $player = Player::create([
                'app_uid' => $sender,
            ]);
        }
        //取得動作
        $data = $this->getData($receiveMessage);
        $action = isset($data->action) ? $data->action : '';
        //TODO: 根據動作選擇處理方式與更新玩家狀態
        if ($action == 'BIND_NID') {
            //點擊綁定NID
            $player->update(['state' => 'INPUT_NID']);
        } elseif ($action == 'CANCEL_BIND_NID') {
            //綁定NID時，按下取消綁定
            $player->update(['state' => '']);
        }

        //TODO: 根據動作與玩家狀態選擇處理方式

        $text = new Text($receiveMessage->getSender(), '施工中...敬請期待');
//        $text->addQuick(new QuickReply('期待', 'EXPECT'))
//            ->addQuick(new QuickReply('不期待', 'NO_EXPECT'));
        $handler->send($text);
    }
}

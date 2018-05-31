<?php

namespace App\Chatbot\Postbacks;

use App\Chatbot\PostbackHandlers\DefaultPostbackHandler;
use App\Chatbot\Tasks\ChallengeTask;
use App\Chatbot\Tasks\NidTask;
use App\Player;
use Casperlaitw\LaravelFbMessenger\Contracts\BaseHandler;
use Casperlaitw\LaravelFbMessenger\Messages\ReceiveMessage;
use Casperlaitw\LaravelFbMessenger\Messages\Text;

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
        //建立或取得玩家
        $player = Player::findOrCreate($sender);
        //取得動作
        $data = app(DefaultPostbackHandler::class)->getData($receiveMessage);
        $action = isset($data->action) ? $data->action : '';
        //根據動作選擇處理方式與更新玩家狀態
        if ($action == 'BIND_NID') {
            //點擊綁定NID
            $player->update(['state' => 'INPUT_NID']);
        } elseif ($action == 'CANCEL_BIND_NID') {
            //綁定NID時，按下取消綁定
            $player->update(['state' => '']);
            $text = new Text($sender, '已取消輸入');
            $handler->send($text);
            //顯示資安大挑戰選單
            app(ChallengeTask::class)->showMenu($handler, $receiveMessage);

            return;
        } elseif ($action == 'ANSWER') {
            //點擊答案
            //觸發作答任務
            app(ChallengeTask::class)->chooseAnswer($handler, $receiveMessage);

            return;
        }

        //根據玩家狀態選擇處理方式
        $state = $player->state;
        if ($state == 'INPUT_NID') {
            app(NidTask::class)->askForInput($handler, $receiveMessage);

            return;
        }
        //若動作為開始挑戰
        if ($action == 'START') {
            //顯示題目
            app(ChallengeTask::class)->showQuestion($handler, $receiveMessage);

            return;
        }
        //顯示選單
        app(ChallengeTask::class)->showMenu($handler, $receiveMessage);
    }
}

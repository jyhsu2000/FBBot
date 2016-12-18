<?php

namespace App\Chatbot\MessageHandlers;

use App\Player;
use App\Keyword;
use App\AutoReplyMessage;
use App\Chatbot\Tasks\NidTask;
use App\Chatbot\Commands\CommandKernel;
use Casperlaitw\LaravelFbMessenger\Messages\Text;
use Casperlaitw\LaravelFbMessenger\Contracts\BaseHandler;
use Casperlaitw\LaravelFbMessenger\Messages\ReceiveMessage;

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
        if (empty($message) && $message !== '0') {
            return;
        }
        //建立或取得玩家
        $sender = $receiveMessage->getSender();
        $player = Player::findOrCreate($sender);
        //根據玩家狀態選擇處理方式
        $state = $player->state;
        if ($state == 'INPUT_NID') {
            app(NidTask::class)->input($this, $receiveMessage);

            return;
        }

        //檢查有無對應指令
        $runSuccess = app(CommandKernel::class)->run($this, $receiveMessage);
        if ($runSuccess) {
            return;
        }
        //檢查對應關鍵字
        $keyword = Keyword::where('keyword', $message)->first();
        if ($keyword) {
            //檢查有無對應訊息
            $autoReplyMessageCount = $keyword->autoReply->autoReplyMessages->count();
            if ($autoReplyMessageCount > 0) {
                //隨機選擇回覆訊息
                /* @var AutoReplyMessage $autoReplyMessage */
                $autoReplyMessage = $keyword->autoReply->autoReplyMessages->random(1);
                //計算次數
                $keyword->increment('counter');
                $autoReplyMessage->increment('counter');
                //傳送訊息
                $this->send(new Text($sender, $autoReplyMessage->content));

                return;
            }
        }

        //無對應指令
        $this->send(new Text($sender, '👤：' . $receiveMessage->getMessage()));
    }
}

<?php

namespace App\Chatbot\Tasks;

use App\Player;
use App\Services\LogService;
use Casperlaitw\LaravelFbMessenger\Contracts\BaseHandler;
use Casperlaitw\LaravelFbMessenger\Messages\QuickReply;
use Casperlaitw\LaravelFbMessenger\Messages\ReceiveMessage;
use Casperlaitw\LaravelFbMessenger\Messages\Text;

class NidTask extends Task
{
    private static $pattern = '/^(([depmv]([0-9]){7})|(t[0-9]{5}))$/i';

    protected $logService;

    /**
     * Create the event listener.
     * @param LogService $logService
     */
    public function __construct(LogService $logService)
    {
        $this->logService = $logService;
    }

    /**
     * 輸入NID
     *
     * @param BaseHandler $handler
     * @param ReceiveMessage $receiveMessage
     * @return mixed
     */
    public function input(BaseHandler $handler, ReceiveMessage $receiveMessage)
    {
        $message = $receiveMessage->getMessage();
        $sender = $receiveMessage->getSender();
        //處理NID
        //檢查NID格式
        if (!preg_match(static::$pattern, $message)) {
            $text = new Text($sender, 'NID格式有誤，請重新輸入');
            $text->addQuick(new QuickReply('取消輸入', 'CHALLENGE ' . json_encode(['action' => 'CANCEL_BIND_NID'])));
            $handler->send($text);

            return;
        }
        $player = Player::findOrCreate($sender);
        $nid = strtoupper($message);
        //檢查NID是否已被綁定
        if (Player::where('nid', $nid)->count()) {
            $text = new Text($sender, '此NID已被綁定過，請重新輸入（若認為被冒用，請洽工作人員）');
            $text->addQuick(new QuickReply('取消輸入', 'CHALLENGE ' . json_encode(['action' => 'CANCEL_BIND_NID'])));
            $handler->send($text);

            return;
        }
        //更新NID
        $player->update(['nid' => $nid]);
        //寫入紀錄
        $this->logService->info('[Player][Bind] ' . $player->app_uid . ' 已綁定 ' . $player->nid . PHP_EOL, [
            'player' => $player,
        ]);
        //傳送訊息
        $text = new Text($receiveMessage->getSender(), '綁定NID：' . $player->nid);
        $handler->send($text);
        //清除輸入中的狀態
        $player->update(['state' => '']);
        //顯示資安大挑戰選單
        app(ChallengeTask::class)->showMenu($handler, $receiveMessage);
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
        $sender = $receiveMessage->getSender();
        $player = Player::findOrCreate($sender);
        //若已有NID
        if ($player->nid) {
            $text = new Text($receiveMessage->getSender(), 'NID：' . $player->nid . PHP_EOL . '（綁定後無法修改）');
            $handler->send($text);
            //清除狀態
            $player->update(['state' => '']);

            return;
        }
        $text = new Text($receiveMessage->getSender(), '請輸入NID' . PHP_EOL . '（只能綁定一次，請小心輸入）');
        $text->addQuick(new QuickReply('取消輸入', 'CHALLENGE ' . json_encode(['action' => 'CANCEL_BIND_NID'])));
        $handler->send($text);
    }
}

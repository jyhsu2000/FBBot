<?php

namespace App\Chatbot\Postbacks;

use App\Chatbot\PostbackHandlers\DefaultPostbackHandler;
use Casperlaitw\LaravelFbMessenger\Contracts\BaseHandler;
use Casperlaitw\LaravelFbMessenger\Messages\ReceiveMessage;

class PostbackKernel
{
    /** @var Postback[]|array */
    public $postbackClasses = [
        MenuPostback::class,
        ChallengePostback::class,
        TalkPostback::class,
    ];

    public function run(BaseHandler $handler, ReceiveMessage $receiveMessage)
    {
        //不處理Postback以外的
        if (empty($receiveMessage->getPostback())) {
            return false;
        }
        //取出關鍵字
        $keyword = app(DefaultPostbackHandler::class)->getKeyword($receiveMessage);
        //逐一檢查關鍵字
        /** @var Postback $runClass */
        $runClass = null;
        foreach ($this->postbackClasses as $postbackClass) {
            $classObject = app($postbackClass);
            if ($classObject->match($keyword)) {
                $runClass = $postbackClass;
                break;
            }
        }
        //無對應關鍵字
        if (!$runClass) {
            return false;
        }
        //執行動作
        app($runClass)->run($handler, $receiveMessage);

        return true;
    }
}

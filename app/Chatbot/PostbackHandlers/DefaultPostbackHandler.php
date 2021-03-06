<?php

namespace App\Chatbot\PostbackHandlers;

use App\Chatbot\Postbacks\PostbackKernel;
use Casperlaitw\LaravelFbMessenger\Contracts\PostbackHandler;
use Casperlaitw\LaravelFbMessenger\Messages\ReceiveMessage;
use Casperlaitw\LaravelFbMessenger\Messages\Text;

class DefaultPostbackHandler extends PostbackHandler
{
    // If webhook get the $payload is `USER_DEFINED_PAYLOAD` will run this postback handler
    protected $payload = '.*'; // You also can use regex!

    /**
     * Handle the chatbot message
     *
     * @param ReceiveMessage $receiveMessage
     *
     * @return mixed
     */
    public function handle(ReceiveMessage $receiveMessage)
    {
        //取出關鍵字
        $keyword = $this->getKeyword($receiveMessage);
        //取出附加資料
        $data = $this->getData($receiveMessage);
        //根據關鍵字決定行為

        //檢查有無對應關鍵字
        $runSuccess = app(PostbackKernel::class)->run($this, $receiveMessage);
        if ($runSuccess) {
            return;
        }

        //無對應關鍵字
        $message = 'KEYWORD: ' . $keyword . PHP_EOL;
        $message .= 'DATA: ' . json_encode($data);
        $text = new Text($receiveMessage->getSender(), $message);
        $this->send($text);
    }

    /**
     * 取出關鍵字
     *
     * @param ReceiveMessage $receiveMessage
     * @return string
     */
    public function getKeyword(ReceiveMessage $receiveMessage)
    {
        $postback = $receiveMessage->getPostback();
        $keyword = explode(' ', $postback, 2)[0];

        return $keyword;
    }

    /**
     * 取出資料
     *
     * @param ReceiveMessage $receiveMessage
     * @return object
     */
    public function getData(ReceiveMessage $receiveMessage)
    {
        $postback = $receiveMessage->getPostback();
        try {
            $dataString = explode(' ', $postback, 2)[1];
            $data = json_decode($dataString);

            return $data;
        } catch (\Exception $exception) {
            return null;
        }
    }
}

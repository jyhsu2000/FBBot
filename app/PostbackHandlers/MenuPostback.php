<?php

namespace App\PostbackHandlers;

use Casperlaitw\LaravelFbMessenger\Contracts\PostbackHandler;
use Casperlaitw\LaravelFbMessenger\Messages\GenericTemplate;
use Casperlaitw\LaravelFbMessenger\Messages\ReceiveMessage;

class MenuPostback extends PostbackHandler
{
    // If webhook get the $payload is `USER_DEFINED_PAYLOAD` will run this postback handler
    protected $payload = 'MENU'; // You also can use regex!

    /**
     * Handle the chatbot message
     *
     * @param ReceiveMessage $message
     *
     * @return mixed
     */
    public function handle(ReceiveMessage $message)
    {
        //顯示選單
        $smallBlackHat = 'http://i.imgur.com/qArK6MG.png';

        $generic = new GenericTemplate($message->getSender());
        $generic->addElement('小黑帽', 'description', $smallBlackHat)
            ->buttons()
            ->addPostBackButton('🚩資安大挑戰', 'CHALLENGE')
            ->addPostBackButton('👄隨便說點什麼吧', 'SAY_SOMETHING')
            ->addWebButton('💻參觀黑客社網站', 'https://hackersir.org/');
        $this->send($generic);
    }
}

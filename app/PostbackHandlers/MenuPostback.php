<?php

namespace App\PostbackHandlers;

use Casperlaitw\LaravelFbMessenger\Contracts\PostbackHandler;
use Casperlaitw\LaravelFbMessenger\Messages\ButtonTemplate;
use Casperlaitw\LaravelFbMessenger\Messages\GenericTemplate;
use Casperlaitw\LaravelFbMessenger\Messages\ReceiveMessage;
use Casperlaitw\LaravelFbMessenger\Messages\Text;

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
        //TODO: 顯示選單
        $button = new ButtonTemplate($message->getSender(), 'Default text');
        $button->setText('Choose')
            ->addPostBackButton('First Bbutton')
            ->addPostBackButton('Second Button')
            ->addPostBackButton('Third button');
        $this->send($button);

        $generic = new GenericTemplate($message->getSender());
        $generic->addElement('First item', 'description')
            ->buttons()
            ->addPostBackButton('First Button')
            ->addWebButton('facebook', 'https://facebook.com');
        $generic->addElement('Second item', 'description')
            ->buttons()
            ->addPostBackButton('Second Button')
            ->addWebButton('google', 'http://www.google.com')
            ->addShareButton();
        $this->send($generic);

        $generic = new GenericTemplate($message->getSender());
        $generic->addElement('First item', 'description')
            ->buttons()
            ->addPostBackButton('First Button')
            ->addAccountLinkButton('My auth url');
        $this->send($generic);
    }
}

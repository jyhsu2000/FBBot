<?php

namespace App\Chatbot\Tasks;

use App\Choice;
use App\Player;
use App\Question;
use Casperlaitw\LaravelFbMessenger\Messages\Text;
use App\Chatbot\PostbackHandlers\DefaultPostbackHandler;
use Casperlaitw\LaravelFbMessenger\Contracts\BaseHandler;
use Casperlaitw\LaravelFbMessenger\Messages\ButtonTemplate;
use Casperlaitw\LaravelFbMessenger\Messages\ReceiveMessage;
use Casperlaitw\LaravelFbMessenger\Messages\GenericTemplate;

class ChallengeTask extends Task
{
    /**
     * 顯示選單
     *
     * @param BaseHandler $handler
     * @param ReceiveMessage $receiveMessage
     * @return mixed
     */
    public function showMenu(BaseHandler $handler, ReceiveMessage $receiveMessage)
    {
        $sender = $receiveMessage->getSender();
        $player = Player::findOrCreate($sender);
        //顯示選單
        $smallBlackHat = 'http://i.imgur.com/qArK6MG.png';

        //NID
        $nidItem = '📲' . ($player->nid ? 'NID：' . $player->nid : '綁定NID');
        $generic = new GenericTemplate($receiveMessage->getSender());
        $generic->addElement('資安大挑戰', '想做什麼呢？', $smallBlackHat)
            ->buttons()
            ->addPostBackButton($nidItem, 'CHALLENGE ' . json_encode(['action' => 'BIND_NID']))
            //TODO: 根據遊玩情況，決定顯示開始挑戰還是繼續挑戰
            ->addPostBackButton('🎮開始挑戰', 'CHALLENGE ' . json_encode(['action' => 'START']))
            //TODO: 根據玩家，連到對應網址
            ->addWebButton('👀查看進度＆記錄', 'https://fbbot.kid7.club/');
        $handler->send($generic);
    }

    /**
     * 自動選擇並顯示題目
     *
     * @param BaseHandler $handler
     * @param ReceiveMessage $receiveMessage
     */
    public function showQuestion(BaseHandler $handler, ReceiveMessage $receiveMessage)
    {
        $sender = $receiveMessage->getSender();
        $player = Player::findOrCreate($sender);
        //系統無題目
        if (Question::count() == 0) {
            $text = new Text($sender, '施工中...敬請期待');
            $handler->send($text);

            return;
        }
        //TODO: 找出題目（本次作答中，尚未完成的第一題）
        $question = Question::first();

        //TODO: 若皆已完成，觸發檢查進度，並選擇第一題（通常不會發生）

        //記錄作答中題號
        $player->update(['in_question' => $question->id]);
        //顯示題目
        $button = new ButtonTemplate($sender);
        $button->setText($question->content);
        $choices = $question->choices;
        $nums = ['1⃣', '2⃣', '3⃣'];
        for ($i = 0; $i < 3 && $i < $choices->count(); $i++) {
            $choice = $choices[$i];
            $button->addPostBackButton($nums[$i] . ' ' . $choice->content, 'CHALLENGE ' . json_encode([
                    'action' => 'ANSWER',
                    'choice' => $choice->id,
                ]));
        }
        $handler->send($button);
    }

    /**
     * 點擊作答按鈕
     *
     * @param BaseHandler $handler
     * @param ReceiveMessage $receiveMessage
     */
    public function chooseAnswer(BaseHandler $handler, ReceiveMessage $receiveMessage)
    {
        $sender = $receiveMessage->getSender();
        $player = Player::findOrCreate($sender);
        $data = app(DefaultPostbackHandler::class)->getData($receiveMessage);
        try {
            $choice = Choice::find($data->choice);
            $question = $choice->question;
        } catch (\Exception $exception) {
            //選項或問題不存在
            $handler->send(new Text($sender, 'Error'));

            return;
        }
        //若點擊非作答中題目的選項，應提示「非作答中題目」
        if ($question->id != $player->in_question) {
            $handler->send(new Text($sender, '非作答中題目'));

            return;
        }
        //TODO: 記錄選擇答案

        //清除作答中的題號
        $player->update(['in_question' => null]);
        //TODO: 若未完成，觸發顯示題目
        //TODO: 若已完成，觸發檢查進度
        $handler->send(new Text($sender, 'TODO'));
    }

    /**
     * 檢查進度
     *
     * @param BaseHandler $handler
     * @param ReceiveMessage $receiveMessage
     */
    public function checkProgress(BaseHandler $handler, ReceiveMessage $receiveMessage)
    {
        //TODO: 若無抽獎資格，取得抽獎資格
        //TODO: 遞增完成次數
    }
}

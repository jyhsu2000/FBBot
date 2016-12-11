<?php

namespace App;

use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Player
 *
 * @property int $id
 * @property string $app_uid
 * @property string $uid
 * @property string $nid
 * @property int $in_question
 * @property int $time
 * @property string $state
 * @property string $uuid
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\AnswerRecord[] $answerRecords
 * @property-read Qualification|null $qualification
 * @method static \Illuminate\Database\Query\Builder|\App\Player whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Player whereAppUid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Player whereUid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Player whereNid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Player whereInQuestion($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Player whereTime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Player whereState($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Player whereUuid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Player whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Player whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Player extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'app_uid',
        'uid',
        'nid',
        'in_question',
        'time',
        'state',
        'uuid',
    ];

    public function answerRecords()
    {
        return $this->hasMany(AnswerRecord::class);
    }

    /**
     * 根據sender找對應玩家
     *
     * @param $senderId
     * @return Player
     */
    public static function findOrCreate($senderId)
    {
        $player = self::where('app_uid', $senderId)->first();
        if (!$player) {
            $player = self::create([
                'app_uid' => $senderId,
                'uuid'    => Uuid::generate(),
            ]);
        }
        if (!$player->uuid) {
            $player->update(['uuid' => Uuid::generate()]);
        }

        return $player;
    }

    /**
     * 找出本次挑戰中，尚未做答的第一題
     * 若回傳為空，表示已完成該次挑戰
     *
     * @return Question|null;
     */
    public function findNextQuestion()
    {
        $this->load('answerRecords.choice');
        //本次挑戰的所有作答記錄
        $answerRecordsOfThisTime = $this->answerRecords()->where('time', $this->time)->get();
        //作答記錄對應的所有選項
        $choiceIds = $answerRecordsOfThisTime->pluck('choice_id');
        //選項對應的所有題目
        $questionIds = Choice::whereIn('id', $choiceIds)->pluck('question_id');
        $question = Question::whereNotIn('id', $questionIds)->orderBy('order')->orderBy('id')->first();

        return $question;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function qualification()
    {
        return $this->hasOne(Qualification::class);
    }
}

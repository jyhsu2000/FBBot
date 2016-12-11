<?php

namespace App;

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
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Player whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Player whereAppUid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Player whereUid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Player whereNid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Player whereInQuestion($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Player whereTime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Player whereState($value)
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
            ]);
        }

        return $player;
    }
}

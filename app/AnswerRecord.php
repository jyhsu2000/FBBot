<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\AnswerRecord
 *
 * @property int $id
 * @property int $player_id
 * @property int $choice_id
 * @property int $time
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Player $player
 * @property-read \App\Choice $choice
 * @method static \Illuminate\Database\Query\Builder|\App\AnswerRecord whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\AnswerRecord wherePlayerId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\AnswerRecord whereChoiceId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\AnswerRecord whereTime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\AnswerRecord whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\AnswerRecord whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class AnswerRecord extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'player_id',
        'choice_id',
        'time',
    ];

    public function player()
    {
        return $this->belongsTo(Player::class);
    }

    public function choice()
    {
        return $this->belongsTo(Choice::class);
    }

    public function getIsCorrectAttribute()
    {
        return $this->choice->is_correct;
    }
}

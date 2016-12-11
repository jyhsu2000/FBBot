<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
}

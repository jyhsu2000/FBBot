<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Qualification extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'player_id',
        'get_at',
    ];

    protected $dates = [
        'get_at',
    ];

    public function player()
    {
        return $this->belongsTo(Player::class);
    }
}

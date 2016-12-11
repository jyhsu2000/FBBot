<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Qualification
 *
 * @property int $id
 * @property int $player_id
 * @property \Carbon\Carbon $get_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Player $player
 * @method static \Illuminate\Database\Query\Builder|\App\Qualification whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Qualification wherePlayerId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Qualification whereGetAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Qualification whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Qualification whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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

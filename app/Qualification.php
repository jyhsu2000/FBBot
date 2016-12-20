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
 * @property bool $force
 * @property-read \App\Player $player
 * @method static \Illuminate\Database\Query\Builder|\App\Qualification whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Qualification wherePlayerId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Qualification whereGetAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Qualification whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Qualification whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Qualification whereForce($value)
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
        'force',
    ];

    protected $dates = [
        'get_at',
    ];

    public function player()
    {
        return $this->belongsTo(Player::class);
    }
}

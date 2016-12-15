<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Keyword
 *
 * @property int $id
 * @property string $keyword
 * @property string $reply
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Keyword whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Keyword whereKeyword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Keyword whereReply($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Keyword whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Keyword whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Keyword extends Model
{
    protected $fillable = [
        'keyword',
        'reply',
    ];
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\AutoReply
 *
 * @property int $id
 * @property string $name
 * @property int $order
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Keyword[] $keywords
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\AutoReplyMessage[] $autoReplyMessages
 * @method static \Illuminate\Database\Query\Builder|\App\AutoReply whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\AutoReply whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\AutoReply whereOrder($value)
 * @method static \Illuminate\Database\Query\Builder|\App\AutoReply whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\AutoReply whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class AutoReply extends Model
{
    protected $fillable = [
        'name',
        'order',
    ];

    public function keywords()
    {
        return $this->hasMany(Keyword::class);
    }

    public function autoReplyMessages()
    {
        return $this->hasMany(AutoReplyMessage::class);
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\AutoReplyMessage
 *
 * @property int $id
 * @property int $auto_reply_id
 * @property string $content
 * @property int $counter
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\AutoReply $autoReply
 * @method static \Illuminate\Database\Query\Builder|\App\AutoReplyMessage whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\AutoReplyMessage whereAutoReplyId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\AutoReplyMessage whereContent($value)
 * @method static \Illuminate\Database\Query\Builder|\App\AutoReplyMessage whereCounter($value)
 * @method static \Illuminate\Database\Query\Builder|\App\AutoReplyMessage whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\AutoReplyMessage whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class AutoReplyMessage extends Model
{
    protected $fillable = [
        'auto_reply_id',
        'content',
        'counter',
    ];

    public function autoReply()
    {
        return $this->belongsTo(AutoReply::class);
    }
}

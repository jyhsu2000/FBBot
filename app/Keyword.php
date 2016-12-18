<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Keyword
 *
 * @property int $id
 * @property int $auto_reply_id
 * @property string $keyword
 * @property int $counter
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Keyword whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Keyword whereKeyword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Keyword whereReply($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Keyword whereCounter($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Keyword whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Keyword whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\AutoReply $autoReply
 * @method static \Illuminate\Database\Query\Builder|\App\Keyword whereAutoReplyId($value)
 */
class Keyword extends Model
{
    protected $fillable = [
        'auto_reply_id',
        'keyword',
        'counter',
    ];

    public function autoReply()
    {
        return $this->belongsTo(AutoReply::class);
    }
}

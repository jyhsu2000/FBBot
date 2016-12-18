<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AutoReplyMessage extends Model
{
    protected $fillable = [
        'auto_reply_id',
        'content',
    ];

    public function autoReply()
    {
        return $this->belongsTo(AutoReply::class);
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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

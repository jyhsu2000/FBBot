<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'app_uid',
        'uid',
        'nid',
        'in_question',
        'time',
        'state',
    ];
}

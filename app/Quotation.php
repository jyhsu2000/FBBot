<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Quotation
 *
 * @property int $id
 * @property string $content
 * @property int $order
 * @property int $counter
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Quotation whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Quotation whereContent($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Quotation whereOrder($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Quotation whereCounter($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Quotation whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Quotation whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Quotation extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order',
        'content',
        'counter',
    ];
}

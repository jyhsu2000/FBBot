<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use ShiftOneLabs\LaravelCascadeDeletes\CascadesDeletes;

/**
 * App\Question
 *
 * @property int $id
 * @property int $order
 * @property string $content
 * @property string $correct_message
 * @property string $wrong_message
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Choice[] $choices
 * @method static \Illuminate\Database\Query\Builder|\App\Question whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Question whereOrder($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Question whereContent($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Question whereCorrectMessage($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Question whereWrongMessage($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Question whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Question whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Question extends Model
{
    use SoftDeletes;
    use CascadesDeletes;

    protected $cascadeDeletes = ['choices'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order',
        'content',
        'correct_message',
        'wrong_message',
    ];

    public function choices()
    {
        return $this->hasMany(Choice::class);
    }
}

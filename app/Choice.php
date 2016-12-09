<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Choice
 *
 * @property integer $id
 * @property integer $question_id
 * @property integer $order
 * @property string $content
 * @property boolean $is_correct
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Question $question
 * @method static \Illuminate\Database\Query\Builder|\App\Choice whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Choice whereQuestionId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Choice whereOrder($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Choice whereContent($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Choice whereIsCorrect($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Choice whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Choice whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Choice extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'question_id',
        'order',
        'content',
        'is_correct',
    ];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}

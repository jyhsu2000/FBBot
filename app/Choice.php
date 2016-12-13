<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use ShiftOneLabs\LaravelCascadeDeletes\CascadesDeletes;

/**
 * App\Choice
 *
 * @property int $id
 * @property int $question_id
 * @property int $order
 * @property string $content
 * @property bool $is_correct
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
 * @property string $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\AnswerRecord[] $answerRecords
 * @method static \Illuminate\Database\Query\Builder|\App\Choice whereDeletedAt($value)
 */
class Choice extends Model
{
    use SoftDeletes;
    use CascadesDeletes;

    protected $cascadeDeletes = ['answerRecords'];
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

    public function answerRecords()
    {
        return $this->hasMany(AnswerRecord::class);
    }
}

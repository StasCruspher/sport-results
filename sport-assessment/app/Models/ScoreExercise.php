<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScoreExercise extends Model
{
    protected $table = 'score_exercise';

    public $timestamps = false;

    protected $fillable = ['score_id', 'exercise_id'];

    public function score()
    {
        return $this->belongsTo(Score::class, 'score_id');
    }

    public function exercise()
    {
        return $this->belongsTo(Exercise::class, 'exercise_id');
    }
}

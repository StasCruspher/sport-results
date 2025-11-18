<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Score extends Model
{
    protected $table = 'score';

    protected $fillable = ['unit_id', 'exercise_count', 'date'];

    public $timestamps = false;
    
    use SoftDeletes;

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }

    public function results()
    {
        return $this->hasMany(Result::class, 'score_id');
    }

    public function scoreExercises()
    {
        return $this->hasMany(ScoreExercise::class, 'score_id');
    }
    
    public function exercises()
    {
        return $this->belongsToMany(Exercise::class, 'score_exercise', 'score_id', 'exercise_id');
    }

}


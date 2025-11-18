<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Exercise extends Model
{
    protected $table = 'exercise';

    protected $fillable = ['exercise_name', 'exercise_desc'];

    public $timestamps = false;

    use SoftDeletes;
    
    public function requirements()
    {
        return $this->hasMany(Requirement::class, 'exercise_id');
    }

    public function scoreExercises()
    {
        return $this->hasMany(ScoreExercise::class, 'exercise_id');
    }

    public function resultExercises()
    {
        return $this->hasMany(ResultExercise::class, 'exercise_id');
    }
    
    public function scores()
    {
        return $this->belongsToMany(Score::class, 'score_exercise', 'exercise_id', 'score_id');
    }
    
    protected static function booted()
    {
        static::deleting(function ($exercise) {
            $exercise->requirements()->delete();
        });
    }
}

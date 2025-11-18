<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResultExercise extends Model
{
    protected $table = 'result_exercise';

    public $timestamps = false;

    protected $fillable = ['result_id', 'exercise_id', 'result', 'point'];

    public function result()
    {
        return $this->belongsTo(Result::class, 'result_id');
    }

    public function exercise()
    {
        return $this->belongsTo(Exercise::class, 'exercise_id');
    }
}

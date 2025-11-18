<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    protected $table = 'result';
    
    public $timestamps = false;

    protected $fillable = [
        'score_id',
        'participant_id',
        'point_sum',
        'phys_fitness_point'
    ];

    public function participant()
    {
        return $this->belongsTo(Participant::class, 'participant_id');
    }

    public function score()
    {
        return $this->belongsTo(Score::class, 'score_id');
    }

    public function exercises()
    {
        return $this->hasMany(ResultExercise::class, 'result_id');
    }
}

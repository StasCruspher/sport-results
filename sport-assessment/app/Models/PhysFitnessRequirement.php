<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhysFitnessRequirement extends Model
{
    protected $table = 'phys_fitness_requirement';

    protected $fillable = [
        'age_group_id',
        'category_id',
        'gender',
        'exercise_threshold',
        'exercise_count',
        'total_points',
        'result'
    ];
    
    public $timestamps = false;

    public function ageGroup()
    {
        return $this->belongsTo(AgeGroup::class, 'age_group_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}

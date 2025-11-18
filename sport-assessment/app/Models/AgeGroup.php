<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class AgeGroup extends Model
{
    protected $table = 'age_group';

    protected $fillable = ['age_group_number', 'gender', 'description'];
    
    public $timestamps = false;

    use SoftDeletes;
    
    public function participants()
    {
        return $this->hasMany(Participant::class, 'age_group_id');
    }

    public function physFitnessRequirements()
    {
        return $this->hasMany(PhysFitnessRequirement::class, 'age_group_id');
    }
    
    protected static function booted()
    {
        static::deleting(function ($ageGroup) {
            $ageGroup->physFitnessRequirements()->delete();
        });
    }
}

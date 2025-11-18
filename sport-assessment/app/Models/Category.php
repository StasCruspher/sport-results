<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Category extends Model
{
    protected $table = 'category';

    protected $fillable = ['category_number', 'description'];
    
    public $timestamps = false;
    
    use SoftDeletes;

    public function participants()
    {
        return $this->hasMany(Participant::class, 'category_id');
    }

    public function physFitnessRequirements()
    {
        return $this->hasMany(PhysFitnessRequirement::class, 'category_id');
    }
    
    protected static function booted()
    {
        static::deleting(function ($category) {
            $category->physFitnessRequirements()->delete();
        });
    }
}

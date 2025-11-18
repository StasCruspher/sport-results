<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Participant extends Model
{
    protected $table = 'participant';

    protected $fillable = [
        'fullname',
        'mil_rank_id',
        'gender',
        'badge_number',
        'category_id',
        'age_group_id',
        'unit_id',
    ];

    public $timestamps = false;
    
    use SoftDeletes;

    public function milRank()
    {
        return $this->belongsTo(MilRank::class, 'mil_rank_id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function ageGroup()
    {
        return $this->belongsTo(AgeGroup::class, 'age_group_id');
    }

    public function results()
    {
        return $this->hasMany(Result::class, 'participant_id');
    }
}

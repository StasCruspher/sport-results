<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class MilRank extends Model
{
    protected $table = 'mil_rank';

    protected $fillable = ['name'];
    
    public $timestamps = false;

    use SoftDeletes;
    
    public function participants()
    {
        return $this->hasMany(Participant::class, 'mil_rank_id');
    }
}

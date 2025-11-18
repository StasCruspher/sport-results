<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Unit extends Model
{
    protected $table = 'unit';

    protected $fillable = ['unit_name'];
    
    public $timestamps = false;
    
    use SoftDeletes;

    public function participants()
    {
        return $this->hasMany(Participant::class, 'unit_id');
    }

    public function scores()
    {
        return $this->hasMany(Score::class, 'unit_id');
    }
}

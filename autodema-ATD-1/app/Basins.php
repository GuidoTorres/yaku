<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Basins extends Model
{
    protected $fillable = [
        'name'
    ];

    public function samplingPoints(){
        return $this->hasMany(SamplingPoint::class);
    }
}

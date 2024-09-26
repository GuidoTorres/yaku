<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Eca extends Model
{
    protected $fillable = [
        'name','description','is_transition'
    ];

    public function samplingPoints(){
        return $this->hasMany(SamplingPoint::class);
    }
    public function ecaParameters(){
        return $this->hasMany(EcaParameter::class);
    }

}

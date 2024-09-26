<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SamplingParameter extends Model
{
    protected $fillable = [
        'parameter_id', 'sampling_id','value','state',
    ];


    public function parameter(){
        return $this->belongsTo(Parameter::class);
    }
    public function sampling(){
        return $this->belongsTo(Sampling::class);
    }

}

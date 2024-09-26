<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EcaParameter extends Model
{
    protected $fillable = [
        'eca_id','parameter_id','min_value','near_min_value','max_value','near_max_value','allowed_value',
    ];


    public function eca(){
        return $this->belongsTo(Eca::class);
    }

    public function parameter(){
        return $this->belongsTo(Parameter::class);
    }

}

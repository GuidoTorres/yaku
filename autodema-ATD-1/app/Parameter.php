<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Parameter extends Model
{
    const POSITIVE_INTEGER = 1;
    const NEGATIVE_INTEGER = 2;
    const INTEGER = 3;
    const POSITIVE_FLOAT = 4;
    const NEGATIVE_FLOAT = 5;
    const FLOAT = 6;
    const STRING = 7;
    const BOOLEAN = 8;
    const ZERO_TO_ONE_DECIMAL = 9;

    const DATA_TYPE_TEXT = [
        Parameter::POSITIVE_INTEGER => "Entero positivo",
        Parameter::NEGATIVE_INTEGER => "Entero negativo",
        Parameter::INTEGER => "Entero",
        Parameter::POSITIVE_FLOAT => "Decimal positivo",
        Parameter::NEGATIVE_FLOAT => "Decimal negativo",
        Parameter::FLOAT => "Decimal",
        Parameter::STRING => "Texto",
        Parameter::BOOLEAN => "Booleano",
        Parameter::ZERO_TO_ONE_DECIMAL => "Decimal de 0 a 1",
    ];

    //ID OF PARAMETERS
    const ALLOWED_PARAMETERS_VISUALIZER = [
        3,
        4,
        5,
        7,
        8,
        10,
        11,
        14,
        15,
        18,
        21,
        24,
        29,
        30,
        31,
        32,
        35,
        36,
        38,
        39,
        40,
        41,
        42,
        44,
        45,
        50,
        51,
        52,
        53,
        54,
        55,
        56,
        57,
        58,
        59,
        60,
        65,
        74,
        75,
        76,
        77,
        78,
        79,
        80
    ];

    protected $fillable = [
        'name', 'description', 'code', 'unit_id', 'data_type'
    ];


    public function unit(){
        return $this->belongsTo(Unit::class);
    }
    public function samplingParameters(){
        return $this->hasMany(SamplingParameter::class);
    }
    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }
    public function roles(){
        return $this->belongsToMany(Role::class)->withTimestamps();
    }

}

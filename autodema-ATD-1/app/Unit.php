<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $fillable = [
        'magnitude', 'unit', 'symbol',
    ];


    public function parameters(){
        return $this->hasMany(Parameter::class);
    }
}

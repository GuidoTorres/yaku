<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    protected $fillable = [
        'name'
    ];

    public function samplingPoints(){
        return $this->hasMany(SamplingPoint::class);
    }
}
